<?php
/**
 * FilterTest.php
 *
 * @lastModification 22.07.2020, 00:37
 * @author Rafał Tadaszak <r.tadaszak@soit.pl>
 * @copyright soIT.pl 2018 - 2020
 * @url http://www.soit.pl
 */

namespace soIT\ValueObjects\Objects\WebManagement;

use Faker\Provider\Lorem;
use Mockery;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use soIT\ValueObjects\Exceptions\InvalidArgumentException;
use soIT\ValueObjects\Exceptions\NotMatchTypeException;
use soIT\ValueObjects\Objects\WebManagement\Enums\FilterOperationsEnum;
use soIT\ValueObjects\Objects\WebManagement\Enums\QueryFilterOperationsEnum;
use soIT\ValueObjects\ValueObjectInterface;

class FilterTest extends TestCase
{
    /**
     * @throws ReflectionException
     * @throws NotMatchTypeException
     */
    public function testIsEqual()
    {
        $operators = FilterOperationsEnum::get();

        foreach ($operators as $operator) {
            $field = Lorem::word();
            $value = Lorem::word();

            $testString = $field.$operator.$value;
            /**
             * @var $filter Filter
             */
            $filter = Filter::makeFromString($testString);
            $filter_ = Filter::makeFromString($testString);

            $this->assertTrue($filter->isEqual($filter_));
        }
    }

    /**
     * @throws NotMatchTypeException
     * @throws ReflectionException
     */
    public function testIsEqualWithWrongField()
    {
        $field = Lorem::word();
        $value = Lorem::word();

        /**
         * @var $filter Filter
         */
        $filter = Filter::makeFromString($field.'='.$value);
        $filter_ = Filter::makeFromString($field.'a'.'='.$value);

        $this->assertFalse($filter->isEqual($filter_));
    }

    /**
     * @throws NotMatchTypeException
     * @throws ReflectionException
     */
    public function testIsEqualWithWrongOperator()
    {
        $field = Lorem::word();
        $value = Lorem::word();

        /**
         * @var $filter Filter
         */
        $filter = Filter::makeFromString($field.'='.$value);
        $filter_ = Filter::makeFromString($field.'<='.$value);

        $this->assertFalse($filter->isEqual($filter_));
    }

    /**
     * @throws NotMatchTypeException
     * @throws ReflectionException
     */
    public function testIsEqualWithWrongValue()
    {
        $field = Lorem::word();
        $value = Lorem::word();

        /**
         * @var $filter Filter
         */
        $filter = Filter::makeFromString($field.'='.$value);
        $filter_ = Filter::makeFromString($field.'='.$value.'a');

        $this->assertFalse($filter->isEqual($filter_));
    }

    /**
     * @throws ReflectionException
     */
    public function testWrongOperator()
    {
        $field = Lorem::word();
        $value = Lorem::word();

        $testString = $field.':'.$value;

        $this->expectException(InvalidArgumentException::class);
        Filter::makeFromString($testString);
    }

    /**
     * @throws ReflectionException
     * @throws NotMatchTypeException
     */
    public function testIsEqualWithWrongObject()
    {
        $field = Lorem::word();
        $value = Lorem::word();

        $testString = $field.'='.$value;
        /**
         * @var $filter Filter
         */
        $filter = Filter::makeFromString($testString);
        $filter_ = Mockery::mock(ValueObjectInterface::class);

        $this->expectException(NotMatchTypeException::class);
        $filter->isEqual($filter_);
    }

    /**
     * @throws ReflectionException
     */
    public function testToString()
    {
        $operators = FilterOperationsEnum::get();

        foreach ($operators as $operator) {
            $field = Lorem::word();
            $value = Lorem::word();

            $testString = $field.$operator.$value;
            /**
             * @var $filter Filter
             */
            $filter = Filter::makeFromString($testString);

            $this->assertEquals($field.' '.$operator.' '.$value, $filter->toString());
        }
    }

    /**
     * @throws ReflectionException
     */
    public function testMakeFromString()
    {
        $operators = FilterOperationsEnum::get();

        foreach ($operators as $key => $operator) {
            $field = Lorem::word();
            $value = Lorem::word();

            $testString = $field.$operator.$value;
            /**
             * @var $filter Filter
             */
            $filter = Filter::makeFromString($testString);

            $this->assertInstanceOf(Filter::class, $filter);
            $this->assertEquals($field, $filter->getField());
            $this->assertEquals($value, $filter->getValue());
            $this->assertEquals(FilterOperationsEnum::getValue($key), $filter->getType());
        }
    }

    /**
     * @throws ReflectionException
     */
    public function testMakeFromQueryString()
    {
        $operators = QueryFilterOperationsEnum::get();

        foreach ($operators as $key => $operator) {
            $field = Lorem::word();
            $value = Lorem::word();

            $testString = $field.$operator.$value;
            /**
             * @var $filter Filter
             */
            $filter = Filter::makeFromQueryString($testString);

            $this->assertInstanceOf(Filter::class, $filter);
            $this->assertEquals($field, $filter->getField());
            $this->assertEquals($value, $filter->getValue());
            $this->assertEquals(FilterOperationsEnum::getValue($key), $filter->getType());
        }
    }

    /**
     * @throws ReflectionException
     */
    public function testMakeFromQueryStringWrongOperator()
    {
        $field = Lorem::word();
        $value = Lorem::word();

        $testString = $field.'='.$value;

        $this->expectException(InvalidArgumentException::class);
        Filter::makeFromQueryString($testString);
    }

    /**
     * @throws ReflectionException
     */
    public function testMakeFromStringWithSpace()
    {
        $operators = FilterOperationsEnum::get();

        foreach ($operators as $key => $operator) {
            $field = Lorem::word();
            $value = Lorem::word();

            $testString = $field.' '.$operator.' '.$value;
            /**
             * @var $filter Filter
             */
            $filter = Filter::makeFromString($testString);

            $this->assertInstanceOf(Filter::class, $filter);
            $this->assertEquals($field, $filter->getField());
            $this->assertEquals($value, $filter->getValue());
            $this->assertEquals(FilterOperationsEnum::getValue($key), $filter->getType());
        }
    }
}
