<?php
/**
 * FullName.php
 *
 * @lastModification 30.12.2019, 11:01
 * @author Rafał Tadaszak <r.tadaszak@soit.pl>
 * @copyright soIT.pl 2018 - 2020
 * @url http://www.soit.pl
 */

namespace soIT\ValueObjects\Objects\Person;

use soIT\ValueObjects\Exceptions\InvalidArgumentException;
use soIT\ValueObjects\ValueObjectInterface;

class FullName implements ValueObjectInterface
{
    /**
     * @var string
     */
    private $firstName = '';
    /**
     * @var string
     */
    private $lastName = '';

    /**
     * FullName constructor.
     *
     * @param string $firstName
     * @param string $lastName
     */
    public function __construct(string $firstName, string $lastName)
    {
        $this->setFirstName($firstName)
             ->setLastName($lastName);
    }

    /**
     * @return string
     */
    public function getFirstName():string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName():string
    {
        return $this->lastName;
    }

    /**
     * Check is object value equal with defined in object
     *
     * @param mixed $fullName Value to check
     *
     * @return bool
     */
    public function isEqual(ValueObjectInterface $fullName):bool
    {
        return $this->toString() === $fullName->toString();
    }

    /**
     * @return mixed Output native value of object
     */
    public function toString():string
    {
        return $this->firstName.' '.$this->lastName;
    }

    /**
     * Parse native object to ValueObject
     *
     * @param string $name
     *
     * @return FullName Proper ValueObject
     */
    public static function makeFromString(string $name):ValueObjectInterface
    {
        $parsed = explode(' ', $name);

        if (count($parsed) === 2) {
            return new self($parsed[0], $parsed[1]);
        } else {
            throw new InvalidArgumentException(
                FullName::class, $name, "Natural form of full name should have two or three words"
            );
        }
    }

    /**
     * @param string $firstName
     *
     * @return $this
     */
    private function setFirstName(string $firstName):self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @param string $lastName
     *
     * @return $this
     */
    private function setLastName(string $lastName):self
    {
        $this->lastName = $lastName;

        return $this;
    }
}
