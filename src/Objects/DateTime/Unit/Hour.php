<?php
/**
 * Hour.php
 *
 * @lastModification 22.07.2020, 00:37
 * @author Rafał Tadaszak <r.tadaszak@soit.pl>
 * @copyright soIT.pl 2018 - 2020
 * @url http://www.soit.pl
 */

namespace soIT\ValueObjects\Objects\DateTime\Unit;

use DateTime;
use Exception;
use ReflectionException;
use soIT\ValueObjects\ValueObjectInterface;

final class Hour extends UnitAbstract implements ValueObjectInterface
{
    public const RANGE = ['min' => 0, "max" => 23];
    public const RANGE_12_FORMAT = ['min' => 1, "max" => 12];

    /**
     * Hour constructor.
     *
     * @param string $value
     *
     * @throws ReflectionException
     */
    public function __construct(string $value)
    {
        $value = $this->convert12To24Format($value);

        parent::__construct((int)$value);
    }

    /**
     * Parse native object to ValueObject
     *
     * @param mixed $value Value to parse
     *
     * @return mixed Proper ValueObject
     * @throws ReflectionException
     */
    public static function makeFromString(string $value):ValueObjectInterface
    {
        return new self($value);
    }

    /**
     * @param string $format
     *
     * @return mixed Output native value of object
     * @throws Exception
     */
    public function toString($format = 'H'):string
    {
        return (new DateTime())->setTime($this->value, '00')->format($format);
    }

    /**
     * @param string $value
     *
     * @return false|string
     * @throws ReflectionException
     */
    private function convert12To24Format(string $value):string
    {
        if ($this->is12HourFormat($value)) {
            $time = preg_replace("/[^0-9]/", "", $value);

            if (self::isValid($time, self::RANGE_12_FORMAT)) {
                return date("H", strtotime($value));
            } else {
                $this->throwInvalidArgumentException(
                    $value,
                    sprintf(
                        $this->getClassShortName(
                        )." hour with ante meridiem or post meridiem must be integer between %d and %d",
                        static::RANGE_12_FORMAT['min'],
                        static::RANGE_12_FORMAT['max']
                    )
                );
            }
        }

        return $value;
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    private function is12HourFormat(string $value):bool
    {
        return is_numeric($value[0]) && stripos($value, 'pm') || stripos($value, 'am');
    }
}
