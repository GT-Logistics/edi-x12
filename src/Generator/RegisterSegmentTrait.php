<?php

namespace Gtlogistics\X12Parser\Generator;

use Gtlogistics\X12Parser\Schema\Loop;
use Gtlogistics\X12Parser\Schema\Segment;
use Gtlogistics\X12Parser\Schema\SegmentInterface;
use Laminas\Code\Generator\AbstractMemberGenerator;
use Laminas\Code\Generator\ClassGenerator;
use Laminas\Code\Generator\DocBlock\Tag\PropertyTag;
use Laminas\Code\Generator\DocBlockGenerator;
use Laminas\Code\Generator\PropertyGenerator;
use Laminas\Code\Generator\TypeGenerator;

trait RegisterSegmentTrait
{
    /**
     * @param SegmentInterface[] $segments
     */
    private function registerSegments(ClassGenerator $class, DocBlockGenerator $docBlock, array $segments): void
    {
        $order = [];
        $loops = [];
        foreach ($segments as $index => $segment) {
            $segmentClass = $this->registerSegment($class, $docBlock, $segment);
            if ($segment instanceof Loop) {
                $firstSegment = $segment->getSegments()[0];

                $loops[$firstSegment->getId()] = $segmentClass;
            }

            $order[$segment->getId()] = $index;
        }

        if (count($loops) > 0) {
            $loopsProperty = new PropertyGenerator('loops', $loops, AbstractMemberGenerator::FLAG_PROTECTED, TypeGenerator::fromTypeString('array'));
            $class->addPropertyFromGenerator($loopsProperty);
        }
        if (count($order) > 0) {
            $orderProperty = new PropertyGenerator('order', $order, AbstractMemberGenerator::FLAG_PROTECTED, TypeGenerator::fromTypeString('array'));
            $class->addPropertyFromGenerator($orderProperty);
        }
    }

    private function registerSegment(ClassGenerator $class, DocBlockGenerator $docBlock, SegmentInterface $segment): string
    {
        $segmentId = $segment->getId();
        $generator = match (true) {
            $segment instanceof Loop => new LoopClassGenerator($this->getRootDirname(), $this->getRootNamespace(), $this->classMap, $segment),
            $segment instanceof Segment => new SegmentClassGenerator($this->getRootDirname(), $this->getRootNamespace(), $this->classMap, $segment),
            default => throw new \RuntimeException('Unsupported segment ' . $segment->getId()),
        };

        $class->addUse($generator->getFullClassName());
        $docBlock->setTag(new PropertyTag($segmentId, $generator->getClassName() . '[]'));

        $generator->write();

        return $generator->getFullClassName();
    }
}
