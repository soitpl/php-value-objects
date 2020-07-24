<?php
/**
 * DayTest.php
 *
 * @lastModification 13.11.2019, 23:34
 * @author Rafał Tadaszak <r.tadaszak@soit.pl>
 * @copyright soIT.pl 2018 - 2020
 * @url http://www.soit.pl
 */

namespace soIT\ValueObjects\Objects\DateTime\Unit;

use Faker\Factory;
use Mockery;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use soIT\ValueObjects\Exceptions\InvalidArgumentException;
use soIT\ValueObjects\Exceptions\NotMatchTypeException;
use soIT\ValueObjects\ValueObjectInterface;

class DayTest extends TestCase
{
    /**
     * @throws ReflectionException
     */
    public function testMakeFromString()
    {
        $faker = Factory::create();

        $dayNo = $faker->dayOfMonth;

        $day = Day::makeFromString($dayNo);

        $this->assertIsInt($day->get());
        $this->assertEquals($dayNo, $day->get());
    }

    /**
     * @throws ReflectionException
     */
    public function testMakeFromStringWithBoundaryValues()
    {
        $day = Day::makeFromString(Day::RANGE['min']);
        $this->assertEquals(Day::RANGE['min'], $day->get());

        $day = Day::makeFromString(Day::RANGE['max']);
        $this->assertEquals(Day::RANGE['max'], $day->get());
    }

    /**
     * @throws ReflectionException
     */
    public function testMakeFromStringWithWrongValue()
    {
        $faker = Factory::create();

        $dayNo = $faker->numberBetween(32, 100);

        $this->expectException(InvalidArgumentException::class);
        Day::makeFromString($dayNo);
    }

    /**
     * @throws ReflectionException
     */
    public function testToString()
    {
        $faker = Factory::create();

        $dayNo = $faker->dayOfMonth;

        $day = Day::makeFromString($dayNo);

        $this->assertIsInt($day->get());
        $this->assertIsString($day->toString());
    }

    /**
     * @throws ReflectionException
     */
    public function testToStringLeadZero()
    {
        $day = Day::makeFromString(5);
        $this->assertEquals('05', $day->toString());

        $day = Day::makeFromString(9);
        $this->assertEquals('09', $day->toString());

        $day = Day::makeFromString(10);
        $this->assertEquals('10', $day->toString());

        $day = Day::makeFromString(15);
        $this->assertEquals('15', $day->toString());
    }

    /**
     * @throws ReflectionException
     */
    public function testEquals()
    {
        $faker = Factory::create();

        $dayNo = $faker->dayOfMonth;

        $day = Day::makeFromString($dayNo);
        $day2 = Day::makeFromString($dayNo);

        $this->assertTrue($day->isEqual($day2));
    }

    /**
     * @throws ReflectionException
     */
    public function testEqualsNoEquals()
    {
        $faker = Factory::create();

        $dayNo = $faker->dayOfMonth;

        do {
            $dayNo2 = $faker->dayOfMonth;
        } while ($dayNo == $dayNo2);

        $day = Day::makeFromString($dayNo);
        $day2 = Day::makeFromString($dayNo2);

        $this->assertFalse($day->isEqual($day2));
    }

    /**
     * @throws ReflectionException
     */
    public function testEqualsWrongObject()
    {
        $faker = Factory::create();

        $dayNo = $faker->dayOfMonth;

        $day = Day::makeFromString($dayNo);
        $day2 = Mockery::mock(ValueObjectInterface::class);

        $this->expectException(NotMatchTypeException::class);
        $day->isEqual($day2);
    }
}
