<?php

declare(strict_types=1);

/*
 * Copyright (C) 2024 GT+ Logistics.
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301
 * USA
 */

namespace Gtlogistics\EdiX12\Loaders;

use Gtlogistics\EdiX12\Schema\Element;
use Gtlogistics\EdiX12\Schema\Loop;
use Gtlogistics\EdiX12\Schema\Release;
use Gtlogistics\EdiX12\Schema\Segment;
use Gtlogistics\EdiX12\Schema\SegmentInterface;
use Gtlogistics\EdiX12\Schema\TransactionSet;
use Gtlogistics\EdiX12\Schema\Types\DateType;
use Gtlogistics\EdiX12\Schema\Types\EnumType;
use Gtlogistics\EdiX12\Schema\Types\FloatType;
use Gtlogistics\EdiX12\Schema\Types\IntegerType;
use Gtlogistics\EdiX12\Schema\Types\StringType;
use Gtlogistics\EdiX12\Schema\Types\TimeType;
use Gtlogistics\EdiX12\Schema\Types\TypeInterface;
use Webmozart\Assert\Assert;

use function Safe\file_get_contents;
use function Safe\preg_match;
use function Safe\scandir;

final class CDataSchemaLoader implements SchemaLoaderInterface
{
    private readonly string $schemaPath;

    private array $schemas = [];

    public function __construct(string $schemaPath)
    {
        Assert::directory($schemaPath);

        $this->schemaPath = $schemaPath;
    }

    public function getRelease(string $releaseId, array $transactionSetIds = []): Release
    {
        $release = new Release($releaseId);

        if (count($transactionSetIds) === 0) {
            $transactionSetIds = $this->guessTransactionSetIdsFromPath($releaseId);
        }

        foreach ($transactionSetIds as $transactionSetId) {
            $transactionSet = $this->getTransactionSet($releaseId, $transactionSetId);

            $release->addTransactionSet($transactionSet);
        }

        return $release;
    }

    /**
     * @return string[]
     */
    private function guessTransactionSetIdsFromPath(string $releaseId): array
    {
        $transactionSetIds = [];

        $files = scandir($this->getReleasePath($releaseId));
        foreach ($files as $file) {
            if (!preg_match('/^\d+\\\\RSSBus_\d+_(\d+)\.json$/', $file, $matches) !== false) {
                continue;
            }

            $transactionSetIds[] = $matches[1];
        }

        return $transactionSetIds;
    }

    private function getTransactionSet(string $releaseId, string $transactionSetId): TransactionSet
    {
        $transactionSetSchema = $this->getTransactionSetSchema($releaseId, $transactionSetId);
        $transactionSet = new TransactionSet($transactionSetId);

        foreach ($transactionSetSchema as $segmentSchema) {
            // Exclude the SE trailer for the transaction set
            if ($segmentSchema['ID'] === 'SE') {
                continue;
            }

            $segment = $this->getSegment($releaseId, $segmentSchema);

            $transactionSet->addSegment($segment);
        }

        return $transactionSet;
    }

    private function getSegment(string $releaseId, array $segmentSchema): SegmentInterface
    {
        $segmentId = $segmentSchema['ID'];
        $min = $segmentSchema['Min'] ?? null;
        $max = $segmentSchema['Max'] ?? null;

        if ($loopSegmentSchemas = $segmentSchema['Loop'] ?? null) {
            $segment = new Loop($segmentId);

            foreach ($loopSegmentSchemas as $loopSegmentSchema) {
                $loopSegment = $this->getSegment($releaseId, $loopSegmentSchema);

                $segment->addSegment($loopSegment);
            }
        } else {
            $segment = new Segment($segmentId);
            $fullSegmentSchema = $this->getSegmentSchema($releaseId, $segmentId);
            $elementSchemas = $fullSegmentSchema['Elements'];

            foreach ($elementSchemas as $index => $elementSchema) {
                $elementIndex = $index + 1;
                $elementType = $this->getElementType($releaseId, $elementSchema);
                $element = new Element(
                    $elementIndex,
                    $elementSchema['Desc'],
                    $elementType,
                    $elementSchema['MinLength'] ?? -1,
                    $elementSchema['MaxLength'] ?? -1,
                    $elementSchema['Required'] ?? false,
                );

                $segment->addElement($element);
            }
        }

        if ($min !== null && $min !== 'unbounded') {
            $segment->setMin($min);
        }
        if ($max !== null && $max !== 'unbounded') {
            $segment->setMax($max);
        }

        return $segment;
    }

    private function getSchema(string $releaseId): array
    {
        $filePath = $this->getReleasePath($releaseId) . DIRECTORY_SEPARATOR . "$releaseId\\RSSBus_$releaseId.json";

        Assert::file($filePath);

        return $this->schemas[$releaseId] ??= json_decode(file_get_contents($filePath), true, 512, JSON_THROW_ON_ERROR);
    }

    private function getSegmentSchema(string $releaseId, string $segmentId): array
    {
        $schema = $this->getSchema($releaseId);

        return $schema['Segments'][$segmentId];
    }

    private function getQualifierSchema(string $releaseId, string $qualifierId): array
    {
        $schema = $this->getSchema($releaseId);

        return $schema['Qualifiers'][$qualifierId];
    }

    private function getTransactionSetSchema(string $releaseId, string $transactionSetId): array
    {
        $filePath = $this->getReleasePath($releaseId) . DIRECTORY_SEPARATOR . "$releaseId\\RSSBus_{$releaseId}_$transactionSetId.json";

        Assert::file($filePath);

        return json_decode(file_get_contents($filePath), true, 512, JSON_THROW_ON_ERROR)['TransactionSet'];
    }

    private function getReleasePath(string $release): string
    {
        return $this->schemaPath . DIRECTORY_SEPARATOR . $release;
    }

    private function getElementType(string $releaseId, array $elementSchema): TypeInterface
    {
        if ($qualifierId = $elementSchema['QualifierRef'] ?? null) {
            $qualifierSchema = $this->getQualifierSchema($releaseId, $qualifierId);

            return new EnumType($qualifierId, $qualifierSchema);
        }
        if ($componentSchemas = $elementSchema['Components'] ?? null) {
            return new StringType();
        }

        $dataType = $elementSchema['DataType'];

        return match ($dataType) {
            'N' => new IntegerType(),
            'R' => new FloatType(),
            'AN', 'ID' => new StringType(),
            'DT' => new DateType(),
            'TM' => new TimeType(),
            default => throw new \RuntimeException('Unknown data type ' . $dataType),
        };
    }
}
