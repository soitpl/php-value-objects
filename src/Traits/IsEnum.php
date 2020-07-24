<?php
/**
 * IsEnum.php
 *
 * @lastModification 22.07.2020, 00:37
 * @author Rafał Tadaszak <r.tadaszak@soit.pl>
 * @copyright soIT.pl 2018 - 2020
 * @url http://www.soit.pl
 */

namespace soIT\ValueObjects\Traits;

use ReflectionClass;
use ReflectionException;

trait IsEnum
{
    /**
     * Get name of the element
     *
     * @throws ReflectionException
     * z
     */
    public static function get()
    {
        return self::getConstants();
    }

    /**
     * Get element value by name
     *
     * @param string $element
     *
     * @return mixed|string
     */
    public static function getValue(string $element):string
    {
        $staticName = self::createStaticName(strtoupper($element));

        return defined($staticName) ? constant($staticName) : $element;
    }

    /**
     * Get constants by value
     *
     * @param string $name Name
     * @param bool $part Searching by part
     *
     * @return bool|string
     * @throws ReflectionException
     */
    public static function getByValue(string $name, bool $part = false):?string
    {
        $name = strtoupper($name);

        foreach (self::getConstants() as $k => $v) {
            if ((!$part && $v == $name) || ($part && stripos($v, $name) !== false)) {
                return $k;
            }
        }

        return null;
    }

    /**
     * @return array
     * @throws ReflectionException
     */
    public static function getValues():array
    {
        return array_values(self::get());
    }

    /**
     * Get all defined elements
     * @throws ReflectionException
     */
    public static function getList():array
    {
        return array_keys(self::get());
    }

    /**
     * Create static name for checking
     *
     * @param string $name Name to create static name
     *
     * @return string
     */
    private static function createStaticName(string $name):string
    {
        return 'static::'.$name;
    }

    /**
     * @return array
     * @throws ReflectionException
     */
    private static function getConstants():array
    {
        return self::reflectCalledClass()->getConstants();
    }

    /**
     * @return ReflectionClass
     * @throws ReflectionException
     */
    private static function reflectCalledClass():ReflectionClass
    {
        return new ReflectionClass(get_called_class());
    }
}