<?php

declare(strict_types=1);

namespace Gtlogistics\EdiX12\Test\Unit\Parser;

use Gtlogistics\EdiX12\Edi;
use Gtlogistics\EdiX12\Exception\MalformedX12Exception;
use Gtlogistics\EdiX12\Heading\GsHeading;
use Gtlogistics\EdiX12\Heading\IsaHeading;
use Gtlogistics\EdiX12\Model\AbstractSegment;
use Gtlogistics\EdiX12\Model\ReleaseInterface;
use Gtlogistics\EdiX12\Parser\X12Parser;
use Gtlogistics\EdiX12\Test\EdiTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(X12Parser::class)]
#[UsesClass(Edi::class)]
#[UsesClass(IsaHeading::class)]
#[UsesClass(GsHeading::class)]
#[UsesClass(AbstractSegment::class)]
class X12ParserTest extends EdiTestCase
{
    private X12Parser $parser;

    protected function setUp(): void
    {
        $release = $this->createStub(ReleaseInterface::class);
        $release->method('supports')
            ->willReturnCallback(static fn (string $code) => $code === '00000')
        ;

        $this->parser = new X12Parser([$release]);
    }

    public function testEmptyEdi(): void
    {
        $this->expectException(MalformedX12Exception::class);
        $this->expectExceptionMessage('The first 3 bytes must be "ISA".');

        $this->parser->parse($this->loadFixture('empty-edi.edi'));
    }

    public function testTrimmedIsaHeading(): void
    {
        $this->expectException(MalformedX12Exception::class);
        $this->expectExceptionMessage('The ISA Header must be 106 characters long.');

        $this->parser->parse($this->loadFixture('trimmed-isa-heading.edi'));
    }

    public function testReleaseNotExist(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Could not found release 00100.');

        $this->parser->parse($this->loadFixture('release-not-exist.edi'));
    }

    public function testInconsistentElementSeparator(): void
    {
        $this->expectException(MalformedX12Exception::class);
        $this->expectExceptionMessage('The ISA Header must be 17 elements long.');

        $this->parser->parse($this->loadFixture('inconsistent-element-separator-isa-heading.edi'));
    }

    public function testNoIsaHeading(): void
    {
        $this->expectException(MalformedX12Exception::class);
        $this->expectExceptionMessage('The IEA trailer does not have a matching ISA segment');

        $this->parser->parse($this->loadFixture('no-isa-heading.edi'));
    }

    public function testNoIeaTrailer(): void
    {
        $this->expectException(MalformedX12Exception::class);
        $this->expectExceptionMessage('The ISA header does not have the termination IEA');

        $this->parser->parse($this->loadFixture('no-iea-trailer.edi'));
    }

    public function testNoGsHeading(): void
    {
        $this->expectException(MalformedX12Exception::class);
        $this->expectExceptionMessage('The GE trailer does not have a matching GS segment');

        $this->parser->parse($this->loadFixture('no-gs-heading.edi'));
    }

    public function testNoGeTrailer(): void
    {
        $this->expectException(MalformedX12Exception::class);
        $this->expectExceptionMessage('The GS header does not have the GE trailer');

        $this->parser->parse($this->loadFixture('no-ge-trailer.edi'));
    }

    public function testNoStHeading(): void
    {
        $this->expectException(MalformedX12Exception::class);
        $this->expectExceptionMessage('The SE trailer does not have a matching ST segment');

        $this->parser->parse($this->loadFixture('no-st-heading.edi'));
    }

    public function testNoSeTrailer(): void
    {
        $this->expectException(MalformedX12Exception::class);
        $this->expectExceptionMessage('The ST header does not have the SE trailer');

        $this->parser->parse($this->loadFixture('no-se-trailer.edi'));
    }

    public function testNoMatchingGsCount(): void
    {
        $this->expectException(MalformedX12Exception::class);
        $this->expectExceptionMessage('The ISA header does not have the declared number of GS in the IEA trailer');

        $this->parser->parse($this->loadFixture('no-matching-gs-count.edi'));
    }

    public function testNoMatchingStCount(): void
    {
        $this->expectException(MalformedX12Exception::class);
        $this->expectExceptionMessage('The GS header does not have the declared number of ST in the GE trailer');

        $this->parser->parse($this->loadFixture('no-matching-st-count.edi'));
    }

    public function testNoMatchingSegmentCount(): void
    {
        $this->expectException(MalformedX12Exception::class);
        $this->expectExceptionMessage('The ST header does not have the declared number of segments in the SE trailer');

        $this->parser->parse($this->loadFixture('no-matching-segment-count.edi'));
    }
}
