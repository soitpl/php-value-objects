<?php
/**
 * Date.php
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
use soIT\ValueObjects\Objects\DateTime\Unit\Month;
use soIT\ValueObjects\Objects\DateTime\Unit\Year;
use soIT\ValueObjects\Traits\ValueObjectTrait;
use soIT\ValueObjects\ValueObjectInterface;

final class Date implements ValueObjectInterface
{
    use ValueObjectTrait;

    /**
     * @var Day
     */
    protected $day;
    /**
     * @var Month
     */
    protected $month;
    /**
     * @var Year
     */
    protected $year;

    /**
     * Date constructor.
     *
     * @param Year $year
     * @param Month $month
     * @param Day $day
     */
    private function __construct(Year $year, Month $month, Day $day)
    {
        $this->day = $day;
        $this->month = $month;
        $this->year = $year;
    }

    /**
     * Get month object
     *
     * @return Day
     */
    public function getDay():Day
    {
        return $this->day;
    }

    /**
     * Get month object
     *
     * @return Month
     */
    public function getMonth():Month
    {
        return $this->month;
    }

    /**
     * Get month object
     *
     * @return Year
     */
    public function getYear():Year
    {
        return $this->year;
    }

    /**
     * Check is object value equal with defined in object
     *
     * @param Date|ValueObjectInterface $object Value to check
     *
     * @return bool
     * @throws NotMatchTypeException
     */
    public function isEqual(ValueObjectInterface $object):bool
    {
        $this->hasEqualType($object);

        return $this->getMonth()->get() === $object->getMonth()->get() &&
               $this->getYear()->get() === $object->getYear()->get() &&
               $this->getDay()->get() === $object->getDay()->get();
    }

    /**
     * @param string $format
     *
     * @return string String value
     * @throws Exception
     */
    public function toString(string $format = 'Y-m-d'):string
    {
        return \DateTime::createFromFormat(
            'Y-m-d',
            implode('-', [$this->year->toString(), $this->month->toString() ?? '01', $this->day->toString() ?? '01'])
        )->format($format);
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

        return new self(
            Year::makeFromString($dateTime->format('Y')),
            Month::makeFromString($dateTime->format('m')),
            Day::makeFromString($dateTime->format('j'))
        );
    }
}
