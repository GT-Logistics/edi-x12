<?php

namespace Gtlogistics\X12Parser\Model;

interface LoopInterface extends WithSegmentsInterface
{
    public function __construct();

    public function getId(): string;

    public static function isFirstSegment(SegmentInterface $segment): bool;

    public static function supportSegment(SegmentInterface $segment): bool;
}
