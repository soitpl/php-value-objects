<?php
/**
 * ValueObjectTrait.php
 *
 * @lastModification 13.01.2020, 19:46
 * @author Rafał Tadaszak <r.tadaszak@soit.pl>
 * @copyright soIT.pl 2018 - 2020
 * @url http://www.soit.pl
 */

namespace soIT\ValueObjects\Traits;

use soIT\ValueObjects\Exceptions\InvalidArgumentException;
use soIT\ValueObjects\Exceptions\NotMatchTypeException;
use soIT\ValueObjects\ValueObjectInterface;

/**
 * Trait ValueObjectTrait
 * @package Core\Shared\ValueObjects\Traits
 */
trait ValueObjectTrait
{
    /**
     * @param string $value
     * @param string|null $message
     *
     * @throws InvalidArgumentException
     */
    protected static function throwInvalidArgumentException(string $value, string $message = null):void
    {
        throw new InvalidArgumentException(static::class, $value, $message);
    }

    /**
     * @param ValueObjectInterface $object
     *
     * @return bool
     * @throws NotMatchTypeException
     */
    protected function hasEqualType(ValueObjectInterface $object):bool
    {
        if (!$this->hasSameType($object)) {
            throw new NotMatchTypeException($this);
        }

        return true;
    }

    /**
     * @param ValueObjectInterface $object
     *
     * @return bool
     */
    protected function hasSameType(ValueObjectInterface $object):bool
    {
        return static::class === get_class($object);
    }
}
