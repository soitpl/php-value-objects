<?php
/**
 * ValueObjectInterface.php
 *
 * @lastModification 22.07.2020, 00:37
 * @author Rafał Tadaszak <r.tadaszak@soit.pl>
 * @copyright soIT.pl 2018 - 2020
 * @url http://www.soit.pl
 */

namespace soIT\ValueObjects;

/**
 * Interface ValueObjectInterface
 * @package Core\Shared\ValueObjects\Interfaces
 */
interface ValueObjectInterface
{
    /**
     * Parse native object to ValueObject
     *
     * @param mixed $value Value to parse
     *
     * @return mixed Proper ValueObject
     */
    public static function makeFromString(string $value):ValueObjectInterface;

    /**
     * Check is object value equal with defined in object
     *
     * @param mixed $valueObject Value to check
     *
     * @return bool
     */
    public function isEqual(ValueObjectInterface $valueObject):bool;

    /**
     * @return mixed Output native value of object
     */
    public function toString():string;
}
