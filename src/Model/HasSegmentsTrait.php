<?php

namespace Gtlogistics\X12Parser\Model;

trait HasSegmentsTrait
{
    /**
     * @var array<string, class-string<LoopInterface>>
     */
    protected array $loops = [];

    /**
     * @var array<string, (SegmentInterface|LoopInterface)[]>
     */
    protected array $segments = [];

    public function getSegments(): array
    {
        $segments = [];

        foreach ($this->segments as $segment) {
            if ($segment instanceof LoopInterface) {
                array_push($segments, ...$segment->getSegments());
            } else {
                $segments[] = $segment;
            }
        }

        return $segments;
    }

    public function setSegments(array $segments): void
    {
        $this->segments = $segments;
    }
}
