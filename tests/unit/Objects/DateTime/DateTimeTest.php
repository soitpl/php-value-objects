<?php
/**
 * DateTimeTest.php
 *
 * @lastModification 13.01.2020, 19:46
 * @author Rafał Tadaszak <r.tadaszak@soit.pl>
 * @copyright soIT.pl 2018 - 2020
 * @url http://www.soit.pl
 */

namespace soIT\ValueObjects\Objects\DateTime;

use Exception;
use Faker\Factory;
use PHPUnit\Framework\TestCase;
use soIT\ValueObjects\Exceptions\NotMatchTypeException;

class DateTimeTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testToString()
    {
        $faker = Factory::create();

        $date = $faker->dateTime();

        $dateObj = DateTime::makeFromString($date->format('Y-m-d H:i:s'));

        $formats = $this->getFormats();

        foreach ($formats as $format) {
            $this->assertEquals($date->format($format), $dateObj->toString($format));
        }
    }

    /**
     * @throws NotMatchTypeException
     * @throws Exception
     */
    public function testIsEqual()
    {
        $faker = Factory::create();

        $date = $faker->dateTime->format('Y-m-d H:i:s');

        $dateObj = DateTime::makeFromString($date);
        $dateObj2 = DateTime::makeFromString($date);

        $this->assertTrue($dateObj->isEqual($dateObj2));
    }

    /**
     * @throws NotMatchTypeException
     * @throws Exception
     */
    public function testIsEqualWithDifferentDate()
    {
        $faker = Factory::create();

        $dateObj = Date::makeFromString($faker->dateTime->format('Y-m-d H:i:s'));
        $dateObj2 = Date::makeFromString($faker->dateTime->format('Y-m-d H:i:s'));

        $this->assertFalse($dateObj->isEqual($dateObj2));
    }

    /**
     * @throws NotMatchTypeException
     * @throws Exception
     */
    public function testIsEqualWithDifferentDay()
    {
        $faker = Factory::create();
        $year = $faker->year;
        $month = $faker->month;

        for ($i = 0; $i < 2; $i++) {
            $days[] = $faker->unique()->dayOfMonth;
        }

        $dateObj = Date::makeFromString(join('-', [$year, $month, $days[0]]));
        $dateObj2 = Date::makeFromString(join('-', [$year, $month, $days[1]]));

        $this->assertFalse($dateObj->isEqual($dateObj2));
    }

    /**
     * @throws NotMatchTypeException
     * @throws Exception
     */
    public function testIsEqualWithDifferentMonth()
    {
        $faker = Factory::create();
        $year = $faker->year;
        $day = $faker->dayOfMonth;

        for ($i = 0; $i < 2; $i++) {
            $months[] = $faker->unique()->month;
        }

        $dateObj = Date::makeFromString(join('-', [$year, $months[0], $day]));
        $dateObj2 = Date::makeFromString(join('-', [$year, $months[1], $day]));

        $this->assertFalse($dateObj->isEqual($dateObj2));
    }

    /**
     * @throws NotMatchTypeException
     * @throws Exception
     */
    public function testIsEqualWithDifferentYear()
    {
        $faker = Factory::create();
        $day = $faker->dayOfMonth;
        $month = $faker->month;

        for ($i = 0; $i < 2; $i++) {
            $years[] = $faker->unique()->year;
        }

        $dateObj = Date::makeFromString(join('-', [$years[0], $month, $day]));
        $dateObj2 = Date::makeFromString(join('-', [$years[1], $month, $day]));

        $this->assertFalse($dateObj->isEqual($dateObj2));
    }

    /**
     * @throws Exception
     */
    public function testMakeFromString()
    {
        $faker = Factory::create();

        $formats = $this->getFormats();

        foreach ($formats as $format) {
            $date = $faker->dateTime->format($format);

            $dateObj = DateTime::makeFromString($date);
            $this->assertEquals($date, $dateObj->toString($format));
        }
    }

    /**
     * @return array
     */
    private function getFormats():array
    {
        return [
            'Y-m-d H:m:s',
            'Y-m-d h:m:s',
            'Y-m-d h a',
            'Y-m-d ha',
            'm/d',
            'm/d/Y',
            'Y-m',
            'd-m-Y',
            'd.m.Y',
            'Y-M-d',
            'Y-M',
            'd.M.Y',
            'M',
            'd M Y',
            "d M"
        ];
    }
}
