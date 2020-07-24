<?php
/**
 * DateTest.php
 *
 * @lastModification 22.07.2020, 00:37
 * @author Rafał Tadaszak <r.tadaszak@soit.pl>
 * @copyright soIT.pl 2018 - 2020
 * @url http://www.soit.pl
 */

namespace soIT\ValueObjects\Objects\DateTime;

use DateTime;
use Exception;
use Faker\Factory;
use PHPUnit\Framework\TestCase;
use soIT\ValueObjects\Exceptions\NotMatchTypeException;

class DateTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testToString()
    {
        $faker = Factory::create();

        $date = $faker->date();

        $dateTime = DateTime::createFromFormat('Y-m-d', $date);
        $dateObj = Date::makeFromString($date);

        $formats = $this->getFormats();

        foreach ($formats as $format) {
            $this->assertEquals($dateTime->format($format), $dateObj->toString($format));
        }
    }

    /**
     * @throws NotMatchTypeException
     * @throws Exception
     */
    public function testIsEqual()
    {
        $faker = Factory::create();

        $date = $faker->date();

        $dateObj = Date::makeFromString($date);
        $dateObj2 = Date::makeFromString($date);

        $this->assertTrue($dateObj->isEqual($dateObj2));
    }

    /**
     * @throws NotMatchTypeException
     * @throws Exception
     */
    public function testIsEqualWithDifferentDate()
    {
        $faker = Factory::create();

        $dateObj = Date::makeFromString($faker->date());
        $dateObj2 = Date::makeFromString($faker->date());

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
            $date = $faker->date($format);

            $dateObj = Date::makeFromString($date);
            $this->assertEquals($date, $dateObj->toString($format));
        }
    }

    private function getFormats():array
    {
        return ['Y-m-d', 'm/d', 'm/d/Y', 'Y-m', 'd-m-Y', 'd.m.Y', 'Y-M-d', 'Y-M', 'd.M.Y', 'M', 'd M Y', "d M"];
    }
}
