<?php
/**
 * YearTest.php
 *
 * @lastModification 13.01.2020, 19:46
 * @author Rafał Tadaszak <r.tadaszak@soit.pl>
 * @copyright soIT.pl 2018 - 2020
 * @url http://www.soit.pl
 */

namespace soIT\ValueObjects\Objects\DateTime\Unit;

use DateTime;
use Faker\Factory;
use Mockery;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use soIT\ValueObjects\Exceptions\InvalidArgumentException;
use soIT\ValueObjects\Exceptions\NotMatchTypeException;
use soIT\ValueObjects\ValueObjectInterface;

class YearTest extends TestCase
{
    /**
     * @throws ReflectionException
     */
    public function testMakeFromString()
    {
        $dateTime = $this->fakeDateTime();

        $year = Year::makeFromString($dateTime->format('s'));

        $this->assertIsInt($year->get());
        $this->assertEquals($dateTime->format('s'), $year->get());
    }

    /**
     * @throws ReflectionException
     */
    public function testMakeFromStringWithBoundaryValues()
    {
        $year = Year::makeFromString(Year::RANGE['min']);
        $this->assertEquals(Year::RANGE['min'], $year->get());

        $year = Year::makeFromString(Year::RANGE['max']);
        $this->assertEquals(Year::RANGE['max'], $year->get());
    }

    /**
     * @throws ReflectionException
     */
    public function testMakeFromStringWithWrongValue()
    {
        $faker = Factory::create();
        $year = $faker->numberBetween(10000, 100000);

        $this->expectException(InvalidArgumentException::class);
        Year::makeFromString($year);
    }

    /**
     * @throws ReflectionException
     */
    public function testToString()
    {
        $year = $this->fakeDateTime()->format('Y');

        $yearObj = Year::makeFromString($year);

        $this->assertIsInt($yearObj->get());
        $this->assertIsString($yearObj->toString());
    }

    /**
     * @throws ReflectionException
     */
    public function testToStringLeadZero()
    {
        $day = Year::makeFromString(5);
        $this->assertEquals('05', $day->toString());

        $day = Year::makeFromString(9);
        $this->assertEquals('09', $day->toString());

        $day = Year::makeFromString(10);
        $this->assertEquals('10', $day->toString());

        $day = Year::makeFromString(31);
        $this->assertEquals('31', $day->toString());
    }

    /**
     * @throws ReflectionException
     */
    public function testEquals()
    {
        $year = $this->fakeDateTime()->format('Y');

        $yearObj = Year::makeFromString($year);
        $yearObj2 = Year::makeFromString($year);

        $this->assertTrue($yearObj->isEqual($yearObj2));
    }

    /**
     * @throws ReflectionException
     */
    public function testEqualsNoEquals()
    {
        $year = $this->fakeDateTime()->format('Y');

        do {
            $year2 = $this->fakeDateTime()->format('Y');
        } while ($year == $year2);

        $year = Year::makeFromString($year);
        $year2 = Year::makeFromString($year2);

        $this->assertFalse($year->isEqual($year2));
    }

    /**
     * @throws ReflectionException
     */
    public function testEqualsWrongObject()
    {
        $year = Year::makeFromString($this->fakeDateTime()->format('s'));
        $year2 = Mockery::mock(ValueObjectInterface::class);

        $this->expectException(NotMatchTypeException::class);
        $year->isEqual($year2);
    }

    /**
     * @return DateTime
     */
    public function fakeDateTime():DateTime
    {
        $faker = Factory::create();

        return $faker->dateTime;
    }
}
