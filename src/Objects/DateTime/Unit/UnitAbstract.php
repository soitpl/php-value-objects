<?php
/**
 * UnitAbstract.php
 *
 * @lastModification 22.07.2020, 00:37
 * @author Rafał Tadaszak <r.tadaszak@soit.pl>
 * @copyright soIT.pl 2018 - 2020
 * @url http://www.soit.pl
 */

namespace soIT\ValueObjects\Objects\DateTime\Unit;

use ReflectionClass;
use ReflectionException;
use soIT\ValueObjects\Exceptions\NotMatchTypeException;
use soIT\ValueObjects\Traits\ValueObjectTrait;
use soIT\ValueObjects\ValueObjectInterface;

abstract class UnitAbstract
{
    use ValueObjectTrait;

    /**
     * @var int
     */
    protected $value;

    /**
     * Year constructor.
     *
     * @param int $value
     *
     * @throws ReflectionException
     */
    public function __construct(int $value)
    {
        if ($this->isValid($value)) {
            $this->value = $value;
        } else {
            $this->throwInvalidArgumentException(
                $value,
                sprintf(
                    $this->getClassShortName()." value must be integer between %d and %d",
                    static::RANGE['min'],
                    static::RANGE['max']
                )
            );
        }
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
        return new static((int)$value);
    }

    /**
     * Get year
     *
     * @return int
     */
    public function get():int
    {
        return $this->value;
    }

    /**
     * Check is object value equal with defined in object
     *
     * @param mixed $valueObject Value to check
     *
     * @return bool
     * @throws NotMatchTypeException
     */
    public function isEqual(ValueObjectInterface $valueObject):bool
    {
        return $this->hasEqualType($valueObject) && $this->get() === $valueObject->get();
    }

    /**
     * @return mixed Output native value of object
     */
    public function toString():string
    {
        return $this->value > 9 ? (string)$this->value : '0'.$this->value;
    }

    /**
     * Is string valid for VO
     *
     * @param string $value
     * @param array|null $range
     *
     * @return bool
     */
    protected function isValid(string $value, ?array $range = null):bool
    {
        return filter_var(
                   $value,
                   FILTER_VALIDATE_INT,
                   [
                       'options' => [
                           'min_range' => $range['min'] ?? static::RANGE['min'],
                           'max_range' => $range['max'] ?? static::RANGE['max']
                       ]
                   ]
               ) !== false;
    }

    /**
     * @return string
     * @throws ReflectionException
     */
    protected function getClassShortName():string
    {
        return (new ReflectionClass($this))->getShortName();
    }
}
