<?php

namespace Gtlogistics\X12Parser\Generator;

interface ClassGeneratorInterface
{
    /**
     * @return non-empty-string
     */
    public function getNamespace(): string;

    /**
     * @return non-empty-string
     */
    public function getClassName(): string;

    /**
     * @return non-empty-string
     */
    public function getFullClassName(): string;

    /**
     * @return non-empty-string
     */
    public function getFilename(): string;

    public function write(): void;
}
