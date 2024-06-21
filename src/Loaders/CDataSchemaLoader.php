<?php

namespace Gtlogistics\X12Parser\Loaders;

use Gtlogistics\X12Parser\Schema\Element;
use Gtlogistics\X12Parser\Schema\Loop;
use Gtlogistics\X12Parser\Schema\Release;
use Gtlogistics\X12Parser\Schema\Segment;
use Gtlogistics\X12Parser\Schema\SegmentInterface;
use Gtlogistics\X12Parser\Schema\TransactionSet;
use Gtlogistics\X12Parser\Schema\Types\DateType;
use Gtlogistics\X12Parser\Schema\Types\EnumType;
use Gtlogistics\X12Parser\Schema\Types\FloatType;
use Gtlogistics\X12Parser\Schema\Types\IntegerType;
use Gtlogistics\X12Parser\Schema\Types\StringType;
use Gtlogistics\X12Parser\Schema\Types\TimeType;
use Gtlogistics\X12Parser\Schema\Types\TypeInterface;

use function Safe\scandir;
use function Safe\preg_match;
use function Safe\file_get_contents;

final class CDataSchemaLoader implements SchemaLoaderInterface
{
    private array $schemas = [];

    public function __construct(private readonly string $schemaPath)
    {
    }

    public function getRelease(string $releaseId, array $transactionSetIds = []): Release
    {
        $release = new Release($releaseId);

        if (count($transactionSetIds) === 0) {
            $files = scandir($this->getReleasePath($releaseId));
            foreach ($files as $file) {
                if (!preg_match('/^\d+_RSSBus_\d+_(\d+)\\.json$/', $file, $matches) !== false) {
                    continue;
                }

                $transactionSetIds[] = $matches[1];
            }
        }

        foreach ($transactionSetIds as $transactionSetId) {
            $transactionSet = $this->getTransactionSet($releaseId, $transactionSetId);

            $release->addTransactionSet($transactionSet);
        }

        return $release;
    }

    private function getTransactionSet(string $releaseId, string $transactionSetId): TransactionSet
    {
        $transactionSetSchema = $this->getTransactionSetSchema($releaseId, $transactionSetId);
        $transactionSet = new TransactionSet($transactionSetId);

        foreach ($transactionSetSchema as $segmentSchema) {
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
                $elementId = str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT);
                $elementType = $this->getElementType($releaseId, $elementSchema);
                $element = new Element(
                    $elementId,
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
        $filePath = $this->getReleasePath($releaseId) . DIRECTORY_SEPARATOR . "{$releaseId}_RSSBus_$releaseId.json";

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
        $filePath = $this->getReleasePath($releaseId) . DIRECTORY_SEPARATOR . "{$releaseId}_RSSBus_{$releaseId}_$transactionSetId.json";

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
