<?php

namespace Gtlogistics\X12Parser\Generator;

interface ClassGeneratorInterface
{
    public function getNamespace(): string;

    public function getClassName(): string;

    public function getFullClassName(): string;

    public function getFilename(): string;

    public function write(): void;
}
