<?php
/**
 * MonthTest.php
 *
 * @lastModification 30.12.2019, 11:01
 * @author Rafał Tadaszak <r.tadaszak@soit.pl>
 * @copyright soIT.pl 2018 - 2020
 * @url http://www.soit.pl
 */

namespace soIT\ValueObjects\Objects\DateTime\Unit;

use Faker\Factory;
use Faker\Generator;
use Mockery;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use soIT\ValueObjects\Exceptions\InvalidArgumentException;
use soIT\ValueObjects\Exceptions\NotMatchTypeException;
use soIT\ValueObjects\ValueObjectInterface;

class MonthTest extends TestCase
{
    /**
     * @throws ReflectionException
     */
    public function testMakeFromString()
    {
        $monthNo = $this->createFaker()->month;
        $month = Month::makeFromString($monthNo);

        $this->assertIsInt($month->get());
        $this->assertEquals($monthNo, $month->get());
    }

    /**
     * @throws ReflectionException
     */
    public function testToString()
    {
        $faker = $this->createFaker();
        $formats = $this->getFormats();

        foreach ($formats as $format) {
            $date = $faker->dateTime();

            $monthObj = Month::makeFromString($date->format('m'));
            $this->assertEquals($date->format($format), $monthObj->toString($format));
        }
    }

    /**
     * @throws ReflectionException
     */
    public function testToStringWithWrongFormatter()
    {
        $faker = $this->createFaker();

        $monthNo = $faker->month;

        $month = Month::makeFromString($monthNo);

        $this->expectException(InvalidArgumentException::class);
        $month->toString('x');
    }

    /**
     * @throws ReflectionException
     */
    public function testMakeFromStringWithBoundaryValues()
    {
        $month = Month::makeFromString(Month::RANGE['min']);
        $this->assertEquals(Month::RANGE['min'], $month->get());

        $month = Month::makeFromString(Month::RANGE['max']);
        $this->assertEquals(Month::RANGE['max'], $month->get());
    }

    /**
     * @throws ReflectionException
     */
    public function testMakeFromStringWithWrongValue()
    {
        $faker = $this->createFaker();

        $monthNo = $faker->numberBetween(13, 100);

        $this->expectException(InvalidArgumentException::class);
        Month::makeFromString($monthNo);
    }

    /**
     * @throws ReflectionException
     */
    public function testToStringLeadZero()
    {
        $month = Month::makeFromString(5);
        $this->assertEquals('05', $month->toString());

        $month = Month::makeFromString(9);
        $this->assertEquals('09', $month->toString());

        $month = Month::makeFromString(10);
        $this->assertEquals('10', $month->toString());

        $month = Month::makeFromString(12);
        $this->assertEquals('12', $month->toString());
    }

    /**
     * @throws ReflectionException
     */
    public function testEquals()
    {
        $faker = $this->createFaker();

        $monthNo = $faker->month;

        $month = Month::makeFromString($monthNo);
        $month2 = Month::makeFromString($monthNo);

        $this->assertTrue($month->isEqual($month2));
    }

    /**
     * @throws ReflectionException
     */
    public function testEqualsNoEquals()
    {
        $faker = $this->createFaker();

        $monthNo = $faker->month;

        do {
            $monthNo2 = $faker->month;
        } while ($monthNo == $monthNo2);

        $month = Month::makeFromString($monthNo);
        $month2 = Month::makeFromString($monthNo2);

        $this->assertFalse($month->isEqual($month2));
    }

    /**
     * @throws ReflectionException
     */
    public function testEqualsWrongObject()
    {
        $faker = $this->createFaker();

        $monthNo = $faker->month;

        $month = Month::makeFromString($monthNo);
        $month2 = Mockery::mock(ValueObjectInterface::class);

        $this->expectException(NotMatchTypeException::class);
        $month->isEqual($month2);
    }

    private function getFormats():array
    {
        return ['F', 'm', 'M', 'n'];
    }

    private function createFaker():Generator
    {
        return Factory::create();
    }
}
