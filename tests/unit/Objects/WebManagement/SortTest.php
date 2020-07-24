<?php
/**
 * SortTest.php
 *
 * @lastModification 13.11.2019, 23:34
 * @author Rafał Tadaszak <r.tadaszak@soit.pl>
 * @copyright soIT.pl 2018 - 2020
 * @url http://www.soit.pl
 */

namespace soIT\ValueObjects\Objects\WebManagement;

use PHPUnit\Framework\TestCase;
use soIT\ValueObjects\Exceptions\InvalidArgumentException;

class SortTest extends TestCase
{
    public function testParseSortWithDefaultDirection()
    {
        $sort = Sort::makeFromString('name');

        $this->assertFalse($sort->isDescending());
        $this->assertEquals('name', $sort->getField());
    }

    public function testParseSortAscending()
    {
        $sort = Sort::makeFromString('name asc');

        $this->assertFalse($sort->isDescending());
        $this->assertEquals('name', $sort->getField());
    }

    public function testParseSortDescending()
    {
        $sort = Sort::makeFromString('id desc');
        $this->assertTrue($sort->isDescending());
        $this->assertEquals('id', $sort->getField());
    }

    public function testParseWrongFormat()
    {
        $this->expectException(InvalidArgumentException::class);
        Sort::makeFromString('id desc mnz');
    }

    public function testParseWrongOrderDirection()
    {
        $this->expectException(InvalidArgumentException::class);
        Sort::makeFromString('id descx');
    }

    public function testOutput()
    {
        $sort = Sort::makeFromString('id desc');

        $this->assertEquals('id DESC', $sort->toString());
    }

    public function testEquals()
    {
        $sort = Sort::makeFromString('id desc');
        $sortEquals = Sort::makeFromString('id desc');
        $sortNonEquals = Sort::makeFromString('id asc');

        $this->assertTrue($sort->isEqual($sortEquals));
        $this->assertFalse($sort->isEqual($sortNonEquals));
    }
}
