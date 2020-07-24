<?php
/**
 * MinuteTest.php
 *
 * @lastModification 22.07.2020, 00:37
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

class MinuteTest extends TestCase
{
    /**
     * @throws ReflectionException
     */
    public function testMakeFromString()
    {
        $dateTime = $this->fakeDateTime();

        $minute = Minutes::makeFromString($dateTime->format('i'));

        $this->assertIsInt($minute->get());
        $this->assertEquals($dateTime->format('i'), $minute->get());
    }

    /**
     * @throws ReflectionException
     */
    public function testMakeFromStringWithBoundaryValues()
    {
        $minute = Minutes::makeFromString(Minutes::RANGE['min']);
        $this->assertEquals(Minutes::RANGE['min'], $minute->get());

        $minute = Minutes::makeFromString(Minutes::RANGE['max']);
        $this->assertEquals(Minutes::RANGE['max'], $minute->get());
    }

    /**
     * @throws ReflectionException
     */
    public function testMakeFromStringWithWrongValue()
    {
        $faker = Factory::create();
        $minute = $faker->numberBetween(61, 300);

        $this->expectException(InvalidArgumentException::class);
        Minutes::makeFromString($minute);
    }

    /**
     * @throws ReflectionException
     */
    public function testToString()
    {
        $minute = $this->fakeDateTime()->format('i');

        $day = Minutes::makeFromString($minute);

        $this->assertIsInt($day->get());
        $this->assertIsString($day->toString());
    }

    /**
     * @throws ReflectionException
     */
    public function testToStringLeadZero()
    {
        $day = Minutes::makeFromString(5);
        $this->assertEquals('05', $day->toString());

        $day = Minutes::makeFromString(9);
        $this->assertEquals('09', $day->toString());

        $day = Minutes::makeFromString(10);
        $this->assertEquals('10', $day->toString());

        $day = Minutes::makeFromString(15);
        $this->assertEquals('15', $day->toString());
    }

    /**
     * @throws ReflectionException
     */
    public function testEquals()
    {
        $minute = $this->fakeDateTime()->format('i');

        $minuteObj = Minutes::makeFromString($minute);
        $minute2 = Minutes::makeFromString($minute);

        $this->assertTrue($minuteObj->isEqual($minute2));
    }

    /**
     * @throws ReflectionException
     */
    public function testEqualsNoEquals()
    {
        $minute = $this->fakeDateTime()->format('i');

        do {
            $minute2 = $this->fakeDateTime()->format('i');
        } while ($minute == $minute2);

        $minute = Minutes::makeFromString($minute);
        $minute2 = Minutes::makeFromString($minute2);

        $this->assertFalse($minute->isEqual($minute2));
    }

    /**
     * @throws ReflectionException
     */
    public function testEqualsWrongObject()
    {
        $minute = Minutes::makeFromString($this->fakeDateTime()->format('i'));
        $minute2 = Mockery::mock(ValueObjectInterface::class);

        $this->expectException(NotMatchTypeException::class);
        $minute->isEqual($minute2);
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
