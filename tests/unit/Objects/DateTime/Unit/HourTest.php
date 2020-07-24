<?php
/**
 * HourTest.php
 *
 * @lastModification 22.07.2020, 00:37
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

class HourTest extends TestCase
{
    /**
     * @throws ReflectionException
     */
    public function testMakeFromString()
    {
        $faker = $this->createFaker();

        $formats = $this->getFormats();

        foreach ($formats as $format) {
            $date = $faker->time($format);

            $hourObj = Hour::makeFromString($date);
            $this->assertEquals($date, $hourObj->toString($format));
        }
    }

    /**
     * @throws ReflectionException
     */
    public function testMakeFromStringWithString()
    {
        $hourObj = Hour::makeFromString($this->createFaker()->word);
        $this->assertEquals('00', $hourObj->toString('H'));
    }

    /**
     * @throws ReflectionException
     */
    public function testMakeFromStringWithBoundaryValues()
    {
        $hour = Hour::makeFromString(Hour::RANGE['min']);
        $this->assertEquals(Hour::RANGE['min'], $hour->get());

        $hour = Hour::makeFromString(Hour::RANGE['max']);
        $this->assertEquals(Hour::RANGE['max'], $hour->get());
    }

    /**
     * @throws ReflectionException
     */
    public function testMakeFromStringWithWrongHour()
    {
        $this->expectException(InvalidArgumentException::class);
        Hour::makeFromString($this->createFaker()->numberBetween(25, 200));
    }

    /**
     * @throws ReflectionException
     */
    public function testMakeFromStringWithMidnight()
    {
        $hourObj = Hour::makeFromString('00:00');
        $this->assertEquals('00', $hourObj->toString('H'));
    }

    /**
     * @throws ReflectionException
     */
    public function testMakeFromStringWithMidnight12FormatHour()
    {
        $hourObj = Hour::makeFromString('12AM');
        $this->assertEquals('00', $hourObj->toString('H'));
    }

    /**
     * @throws ReflectionException
     */
    public function testMakeFromStringWithWrong12FormatHour()
    {
        $this->expectException(InvalidArgumentException::class);
        Hour::makeFromString($this->createFaker()->numberBetween(13, 24).'AM');
    }

    /**
     * @throws ReflectionException
     */
    public function testToStringFormats()
    {
        $faker = $this->createFaker();

        $formats = $this->getFormats();

        foreach ($formats as $format) {
            $date = $faker->dateTime();

            $hourObj = Hour::makeFromString($date->format('H'));
            $this->assertEquals($date->format($format), $hourObj->toString($format));
        }
    }

    /**
     * @throws ReflectionException
     */
    public function testEquals()
    {
        $hour = $this->createFaker()
                     ->dateTime()
                     ->format('H');

        $hourObj = Hour::makeFromString($hour);
        $hourObj2 = Hour::makeFromString($hour);

        $this->assertTrue($hourObj->isEqual($hourObj2));
    }

    /**
     * @throws ReflectionException
     */
    public function testEqualsNoEquals()
    {
        $hour = $this->createFaker()
                     ->dateTime()
                     ->format('H');

        do {
            $hour2 = $this->createFaker()
                          ->dateTime()
                          ->format('H');
        } while ($hour == $hour2);

        $this->assertFalse(Hour::makeFromString($hour)->isEqual(Hour::makeFromString($hour2)));
    }

    /**
     * @throws ReflectionException
     */
    public function testEqualsWrongObject()
    {
        $hour = Hour::makeFromString(
            $this->createFaker()
                 ->dateTime()
                 ->format('H')
        );
        $hour2 = Mockery::mock(ValueObjectInterface::class);

        $this->expectException(NotMatchTypeException::class);
        $hour->isEqual($hour2);
    }

    private function getFormats():array
    {
        return ['ga', 'ga', 'G', 'H', 'h'];
    }

    private function createFaker():Generator
    {
        return Factory::create();
    }
}
