<?php
/**
 * DateTime.php
 *
 * @lastModification 22.07.2020, 00:37
 * @author Rafał Tadaszak <r.tadaszak@soit.pl>
 * @copyright soIT.pl 2018 - 2020
 * @url http://www.soit.pl
 */

namespace soIT\ValueObjects\Objects\DateTime;

use Exception;
use soIT\ValueObjects\Exceptions\NotMatchTypeException;
use soIT\ValueObjects\Objects\DateTime\Unit\Day;
use soIT\ValueObjects\Objects\DateTime\Unit\Hour;
use soIT\ValueObjects\Objects\DateTime\Unit\Minutes;
use soIT\ValueObjects\Objects\DateTime\Unit\Month;
use soIT\ValueObjects\Objects\DateTime\Unit\Seconds;
use soIT\ValueObjects\Objects\DateTime\Unit\Year;
use soIT\ValueObjects\Traits\ValueObjectTrait;
use soIT\ValueObjects\ValueObjectInterface;

final class DateTime implements ValueObjectInterface
{
    use ValueObjectTrait;

    /**
     * @var Day
     */
    private $day;
    /**
     * @var Month
     */
    private $month;
    /**
     * @var Year
     */
    private $year;
    /**
     * @var Hour
     */
    private $hour;
    /**
     * @var Minutes
     */
    private $minutes;
    /**
     * @var Seconds
     */
    private $seconds;

    /**
     * Get month object
     *
     * @return string
     */
    public function getDay():string
    {
        return $this->day->toString();
    }

    /**
     * Get month object
     *
     * @return string
     * @throws Exception
     */
    public function getMonth():string
    {
        return $this->month->toString();
    }

    /**
     * Get month object
     *
     * @return Year
     */
    public function getYear():string
    {
        return $this->year->toString();
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getHour():string
    {
        return $this->hour->toString();
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getMinutes():string
    {
        return $this->minutes->toString();
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getSeconds():string
    {
        return $this->seconds->toString();
    }

    /**
     * Check is object value equal with defined in object
     *
     * @param Date|ValueObjectInterface $object Value to check
     *
     * @return bool
     * @throws NotMatchTypeException
     * @throws Exception
     */
    public function isEqual(ValueObjectInterface $object):bool
    {
        $this->hasEqualType($object);

        return $this->getMonth() === $object->getMonth() &&
               $this->getYear() === $object->getYear() &&
               $this->getDay() === $object->getDay() &&
               $this->getHour() === $object->getHour() &&
               $this->getMinutes() === $object->getMinutes() &&
               $this->getSeconds() === $object->getSeconds();
    }

    /**
     * @param string $format
     *
     * @return string String value
     * @throws Exception
     */
    public function toString(string $format = 'Y-m-d H:i:s'):string
    {
        return \DateTime::createFromFormat('Y-m-d H:i:s', $this->dateToString().' '.$this->timeToString())->format(
            $format
        );
    }

    /**
     * Parse native object to ValueObject
     *
     * @param string $value Value to parse
     *
     * @return Date|ValueObjectInterface Proper ValueObject
     * @throws Exception
     */
    public static function makeFromString(string $value):ValueObjectInterface
    {
        $dateTime = new \DateTime($value);

        return (new self())
            ->setDate(
                Year::makeFromString($dateTime->format('Y')),
                Month::makeFromString($dateTime->format('n')),
                Day::makeFromString($dateTime->format('j'))
            )
            ->setTime(
                Hour::makeFromString($dateTime->format('H')),
                Minutes::makeFromString($dateTime->format('i')),
                Seconds::makeFromString($dateTime->format('s'))
            );
    }

    /**
     * @param Year $year
     * @param Month $month
     * @param Day $day
     *
     * @return DateTime
     */
    private function setDate(Year $year, Month $month, Day $day):self
    {
        $this->day = $day;
        $this->month = $month;
        $this->year = $year;

        return $this;
    }

    /**
     * @param Hour $hour
     * @param Minutes $minutes
     * @param Seconds $seconds
     *
     * @return DateTime
     */
    private function setTime(Hour $hour, Minutes $minutes, Seconds $seconds):self
    {
        $this->hour = $hour;
        $this->minutes = $minutes;
        $this->seconds = $seconds;

        return $this;
    }

    /**
     * @return string
     * @throws Exception
     */
    private function dateToString():string
    {
        return implode('-', [$this->getYear(), $this->getMonth(), $this->getDay()]);
    }

    /**
     * @return string
     * @throws Exception
     */
    private function timeToString():string
    {
        return implode(':', [$this->getHour(), $this->getMinutes(), $this->getSeconds()]);
    }
}
