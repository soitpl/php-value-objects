<?php
/**
 * SecondTest.php
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

class SecondTest extends TestCase
{
    /**
     * @throws ReflectionException
     */
    public function testMakeFromString()
    {
        $dateTime = $this->fakeDateTime();

        $second = Seconds::makeFromString($dateTime->format('s'));

        $this->assertIsInt($second->get());
        $this->assertEquals($dateTime->format('s'), $second->get());
    }

    /**
     * @throws ReflectionException
     */
    public function testMakeFromStringWithBoundaryValues()
    {
        $second = Seconds::makeFromString(Seconds::RANGE['min']);
        $this->assertEquals(Seconds::RANGE['min'], $second->get());

        $second = Seconds::makeFromString(Seconds::RANGE['max']);
        $this->assertEquals(Seconds::RANGE['max'], $second->get());
    }

    /**
     * @throws ReflectionException
     */
    public function testMakeFromStringWithWrongValue()
    {
        $faker = Factory::create();
        $second = $faker->numberBetween(61, 300);

        $this->expectException(InvalidArgumentException::class);
        Seconds::makeFromString($second);
    }

    /**
     * @throws ReflectionException
     */
    public function testToString()
    {
        $second = $this->fakeDateTime()->format('s');

        $secondObj = Seconds::makeFromString($second);

        $this->assertIsInt($secondObj->get());
        $this->assertIsString($secondObj->toString());
    }

    /**
     * @throws ReflectionException
     */
    public function testToStringLeadZero()
    {
        $day = Seconds::makeFromString(5);
        $this->assertEquals('05', $day->toString());

        $day = Seconds::makeFromString(9);
        $this->assertEquals('09', $day->toString());

        $day = Seconds::makeFromString(10);
        $this->assertEquals('10', $day->toString());

        $day = Seconds::makeFromString(31);
        $this->assertEquals('31', $day->toString());
    }

    /**
     * @throws ReflectionException
     */
    public function testEquals()
    {
        $second = $this->fakeDateTime()->format('s');

        $secondObj = Seconds::makeFromString($second);
        $secondObj2 = Seconds::makeFromString($second);

        $this->assertTrue($secondObj->isEqual($secondObj2));
    }

    /**
     * @throws ReflectionException
     */
    public function testEqualsNoEquals()
    {
        $second = $this->fakeDateTime()->format('s');

        do {
            $second2 = $this->fakeDateTime()->format('s');
        } while ($second == $second2);

        $second = Seconds::makeFromString($second);
        $second2 = Seconds::makeFromString($second2);

        $this->assertFalse($second->isEqual($second2));
    }

    /**
     * @throws ReflectionException
     */
    public function testEqualsWrongObject()
    {
        $second = Seconds::makeFromString($this->fakeDateTime()->format('s'));
        $second2 = Mockery::mock(ValueObjectInterface::class);

        $this->expectException(NotMatchTypeException::class);
        $second->isEqual($second2);
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
