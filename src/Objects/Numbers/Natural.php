<?php
/**
 * Natural.php
 *
 * @lastModification 22.07.2020, 00:37
 * @author Rafał Tadaszak <r.tadaszak@soit.pl>
 * @copyright soIT.pl 2018 - 2020
 * @url http://www.soit.pl
 */

namespace soIT\ValueObjects\Objects\Numbers;

use soIT\ValueObjects\Exceptions\InvalidArgumentException;
use soIT\ValueObjects\ValueObjectInterface;

final class Natural implements ValueObjectInterface
{
    /**
     * @var int Natural number
     */
    private $number;

    /**
     * Returns a Natural object with value given in argument
     *
     * @param int $number Value to set
     */
    public function __construct($number)
    {
        if ($this->isValid($number)) {
            $this->number = $number;
        } else {
            throw new InvalidArgumentException(__CLASS__, $number);
        }
    }

    /**
     * Parse native object to ValueObject
     *
     * @param mixed $value Value to parse
     *
     * @return mixed Proper ValueObject
     */
    public static function parse($value):ValueObjectInterface
    {
        // TODO: Implement parse() method.
    }

    /**
     * Return number assigned to object
     *
     * @return mixed Output native value of object
     */
    public function output():int
    {
        return $this->number;
    }

    /**
     * Check is object value equal with defined in object
     *
     * @param mixed $valueObject Value to check
     *
     * @return bool
     */
    public function isEqual(ValueObjectInterface $valueObject):bool
    {
        // TODO: Implement isEqual() method.
    }

    /**
     * @return mixed Output native value of object
     */
    public function toString():string
    {
        // TODO: Implement toString() method.
    }

    /**
     * Parse native object to ValueObject
     *
     * @param mixed $value Value to parse
     *
     * @return mixed Proper ValueObject
     */
    public static function makeFromString(string $value):ValueObjectInterface
    {
        // TODO: Implement fromString() method.
    }

    /**
     * Is string valid for VO
     *
     * @param string $value
     *
     * @return bool
     */
    private function isValid(string $value):bool
    {
        return ctype_digit($value);
    }
}
