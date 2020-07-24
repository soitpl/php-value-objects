<?php
/**
 * Filter.php
 *
 * @lastModification 17.01.2020, 23:53
 * @author Rafał Tadaszak <r.tadaszak@soit.pl>
 * @copyright soIT.pl 2018 - 2020
 * @url http://www.soit.pl
 */

namespace soIT\ValueObjects\Objects\WebManagement;

use ReflectionException;
use soIT\ValueObjects\Exceptions\NotMatchTypeException;
use soIT\ValueObjects\Objects\WebManagement\Enums\FilterOperationsEnum;
use soIT\ValueObjects\Objects\WebManagement\Enums\QueryFilterOperationsEnum;
use soIT\ValueObjects\Traits\ValueObjectTrait;
use soIT\ValueObjects\ValueObjectInterface;

class Filter implements ValueObjectInterface
{
    use ValueObjectTrait;

    /**
     * @var string
     */
    private $type = FilterOperationsEnum::EQUALITY;
    /**
     * @var string
     */
    private $field = '';
    /**
     * @var string
     */
    private $value = '';

    /**
     * Filter constructor.
     *
     * @param array $filter
     */
    private function __construct(array $filter)
    {
        $this->setField($filter[0]);
        $this->setValue($filter[1]);
        $this->setType($filter[2]);
    }

    /**
     * @inheritDoc
     *
     * @param string $value
     *
     * @return ValueObjectInterface
     * @throws ReflectionException
     */
    public static function makeFromQueryString(string $value):ValueObjectInterface
    {
        $filter = self::parseString($value, QueryFilterOperationsEnum::getValues());

        if (is_null($filter)) {
            self::throwInvalidArgumentException($value);
        }

        $filter[2] = FilterOperationsEnum::getValue(QueryFilterOperationsEnum::getByValue($filter[2]));

        return new self($filter);
    }

    /**
     * @param string $string
     *
     * @param array $operators
     *
     * @return array|null
     */
    private static function parseString(string $string, array $operators):?array
    {
        usort($operators, fn($a, $b) => strlen($b) - strlen($a));

        foreach ($operators as $operator) {
            $filter = self::tryParseString($string, $operator);

            if (!is_null($filter)) {
                return $filter;
            }
        }

        return null;
    }

    /**
     * @param string $string
     * @param string $operator
     *
     * @return array|null
     */
    private static function tryParseString(string $string, string $operator):?array
    {
        $exploded = explode($operator, $string);

        if (count($exploded) == 2) {
            $exploded[2] = $operator;

            return $exploded;
        }

        return null;
    }

    /**
     * @param ValueObjectInterface|Filter $valueObject
     *
     * @return bool
     * @throws NotMatchTypeException
     */
    public function isEqual(ValueObjectInterface $valueObject):bool
    {
        $this->hasEqualType($valueObject);
        return $this->getField() == $valueObject->getField()
               && $this->getValue() == $valueObject->getValue()
               && $this->getType() == $valueObject->getType();
    }

    /**
     * @inheritDoc
     */
    public function toString():string
    {
        return $this->getField().' '.$this->getType().' '.$this->getValue();
    }

    /**
     * @inheritDoc
     * @throws ReflectionException
     */
    public static function makeFromString(string $value):ValueObjectInterface
    {
        $filter = self::parseString($value, FilterOperationsEnum::getValues());

        if (is_null($filter)) {
            self::throwInvalidArgumentException($value);
        }

        return new self($filter);
    }

    /**
     * @return string
     */
    public function getField():string
    {
        return $this->field;
    }

    /**
     * @return string
     */
    public function getValue():string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getType():string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    private function setType(string $type):void
    {
        $this->type = $type;
    }

    /**
     * @param string $field
     */
    private function setField(string $field):void
    {
        $this->field = trim($field);
    }

    /**
     * @param string $value
     */
    private function setValue(string $value):void
    {
        $this->value = trim($value);
    }
}
