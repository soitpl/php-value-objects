<?php
/**
 * Sort.php
 *
 * @lastModification 22.07.2020, 00:36
 * @author Rafał Tadaszak <r.tadaszak@soit.pl>
 * @copyright soIT.pl 2018 - 2020
 * @url http://www.soit.pl
 */

namespace soIT\ValueObjects\Objects\WebManagement;

use soIT\ValueObjects\Exceptions\InvalidArgumentException;
use soIT\ValueObjects\ValueObjectInterface;

class Sort implements ValueObjectInterface
{
    /**
     * @var string Sort $field
     */
    private $field;

    /**
     * @var bool Is sort descending?
     */
    private $descending = false;

    /**
     * @param string $value Parse sort string to array
     *
     * @return array
     */
    private static function parseString(string $value):array
    {
        $parts = explode(' ', $value);

        if (count($parts) === 1) {
            $parts[1] = 'asc';
        }

        return $parts;
    }

    /**
     * Validate is correct value from parsed array
     *
     * @param array $parts
     *
     * @return bool
     */
    private static function validateFromArray(array $parts):bool
    {
        $message = null;

        if (count($parts) != 2) {
            $message = 'String can contains maximum two words, separated by space';
        } elseif (!in_array(strtolower($parts[1]), ['asc', 'desc'])) {
            $message = 'Order direction could be only ASC or DESC';
        }

        if ($message) {
            throw new InvalidArgumentException(Sort::class, $parts[0], $message);
        }

        return true;
    }

    /**
     * Check is object value equal with defined in object
     *
     * @param ValueObjectInterface $valueObject Value to check
     *
     * @return bool
     */
    public function isEqual(ValueObjectInterface $valueObject):bool
    {
        /**
         * @var Sort $valueObject
         */
        return $this->isSortObject($valueObject) &&
               $valueObject->isDescending() == $this->isDescending() &&
               $valueObject->getField() == $this->getField();
    }

    /**
     * @return string Output native value of object
     */
    public function toString():string
    {
        return strtolower($this->field).($this->isDescending() ? ' DESC' : " ASC");
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
        $sort = new self();
        $parts = self::parseString($value);

        if (self::validateFromArray($parts)) {
            $sort->field = $parts[0];

            if (strtolower($parts[1]) == 'desc') {
                $sort->setDescending();
            }
        }

        return $sort;
    }

    /**
     * Get sort field
     *
     * @return string Sort field
     */
    public function getField():string
    {
        return $this->field;
    }

    /**
     * Check is sort descending
     *
     * @return bool
     */
    public function isDescending():bool
    {
        return $this->descending;
    }

    /**
     * To string method
     *
     * @return string
     * @codeCoverageIgnore
     */
    public function __toString():string
    {
        return $this->toString();
    }

    /**
     * @param $object
     *
     * @return bool
     */
    private function isSortObject($object):bool
    {
        return $object instanceof self;
    }

    /**
     * Set descending sort
     */
    private function setDescending():void
    {
        $this->descending = true;
    }
}
