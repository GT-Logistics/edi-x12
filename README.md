# edi-x12
A library to read and write EDI in the X12 standard.

It generates a set of POPO (Plain Old PHP Objects) from the schemas supported 
(currently is only supported the CData Arc EDI Schemas) to work with a strict parser
of EDI. It forces the correct order, length and types defined through the schema.


## Installation
You must have composed installed

```bash
composer require gtlogistics/edi-x12
```

## First use
First, you must need to download the schemas supported for this library 
for all the releases that you need to support (like 00401 or 00601, etc.).
- CData Arc EDI Schemas: https://arc.cdata.com/schemas/

Then, you must create a folder structure like the following
* `[schemas dir]/`: The root dir for the schemas to search, defaults to "schemas/".
* `[schemas dir]/[release dir]`: The dir for the release. It **MUST** be the same as the release number (like "00401").

You must create one dir per release that you want to generate.

After this, you must execute the following command to generate the PHP classes.
```bash
php vendor/bin/edi-generator --schema-path [schemas dir] --output-path [output dir] --transactions-sets [transaction sets] [namespace] [release]
```

Where:
- --schema-path: The directory where the schemas were located (optional, defaults to "schemas/").
- --output-path: The directory where the POPO classes will be generated (optional, defaults to "generated/").
- --transactions-sets: The specific transaction sets IDs (like 204 pr 997) to generate (optional, defaults to all).
- [namespace]: The namespace for the generated classes.
- [release]: The release to generate.

## Usage
### Serialize
```php
use Gtlogistics\EdiX12\Edi;
use Gtlogistics\EdiX12\Heading\GsHeading;
use Gtlogistics\EdiX12\Heading\IsaHeading;
use Gtlogistics\EdiX12\Serializer\X12Serializer;
use My\App\Qualifier\FunctionalGroupAcknowledgeCode;
use My\App\Qualifier\FunctionalIdentifierCode;
use My\App\Qualifier\TransactionSetIdentifierCode;
use My\App\Segment\AK1Segment;
use My\App\Segment\AK9Segment;
use My\App\TransactionSet\TransactionSet997;

$dateTime = new \DateTimeImmutable('2024-01-31 11:00:00');
$serialize = new X12Serializer(
    '*', // Element delimiter
    '~', // Segment delimiter
);

$ak1 = new AK1Segment();
$ak1->_01 = FunctionalIdentifierCode::SM;
$ak1->_02 = 1;

$ak9 = new AK9Segment();
// You can also use the self-explanatory aliases provided by the library!
$ak9->functionalGroupAcknowledgeCode_01 = FunctionalGroupAcknowledgeCode::ACCEPTED_A;
$ak9->numberOfTransactionSetsIncluded_02 = 1;
$ak9->numberOfReceivedTransactionSets_03 = 1;
$ak9->numberOfAcceptedTransactionSets_04 = 1;

$st = new TransactionSet997();
$st->_01 = TransactionSetIdentifierCode::_997;
$st->_02 = '1000';
$st->AK1[] = $ak1;
$st->AK9[] = $ak9;

$gs = new GsHeading();
$gs->_01 = 'FA';
$gs->_02 = 'SENDERAPP';
$gs->_03 = 'RECEIVERAPP';
$gs->_04 = $dateTime;
$gs->_05 = $dateTime;
$gs->_06 = 100;
$gs->_07 = 'X';
$gs->_08 = '004010';
$gs->ST[] = $st;

$isa = new IsaHeading();
$isa->_01 = '00';
$isa->_03 = '00';
$isa->_05 = 'ZZ';
$isa->_06 = 'SENDER';
$isa->_07 = 'ZZ';
$isa->_08 = 'RECEIVER';
$isa->_09 = $dateTime;
$isa->_10 = $dateTime;
$isa->_11 = 'U';
$isa->_12 = '00401';
$isa->_13 = 10;
$isa->_14 = '0';
$isa->_15 = 'P';
$isa->_16 = '`';
$isa->GS[] = $gs;

$edi = new Edi();
$edi->ISA[] = $isa;

file_put_contents('path/to/file.edi', $serialize->serialize($edi));
```

### Parsing
```php
use Gtlogistics\EdiX12\Parser\X12Parser;
use My\App\Release\Release00401;
use My\App\Release\Release00601;
use My\App\TransactionSet\TransactionSet997;

$release00401 = new Release00401();
$release00601 = new Release00601();
$parser = new X12Parser([$release00401, $release00601]);

$edi = $parser->parse(file_get_contents('path/to/file.edi'));
$isa = $edi->ISA[0];
$gs = $isa->GS[0];
$st = $gs->ST[0];

if ($st instanceof TransactionSet997) {
    // Do something with the transaction set
    $ak1 = $st->AK1[0];
    
    echo $ak1->_01->value; // Return SM
    echo $ak1->functionalIdentifierCode_01->value; // Or with the alias
}
```
