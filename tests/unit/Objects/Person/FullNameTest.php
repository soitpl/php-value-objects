<?php
/**
 * FullNameTest.php
 *
 * @lastModification 22.07.2020, 00:37
 * @author Rafał Tadaszak <r.tadaszak@soit.pl>
 * @copyright soIT.pl 2018 - 2020
 * @url http://www.soit.pl
 */

namespace soIT\ValueObjects\Objects\Person;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use soIT\ValueObjects\Exceptions\InvalidArgumentException;

class FullNameTest extends TestCase
{
    public function testToStringWithoutSecondName()
    {
        $faker = Factory::create();

        $firstName = $faker->firstName;
        $lastName = $faker->lastName;

        $fullName = new FullName($firstName, $lastName);

        $this->assertEquals($firstName.' '.$lastName, $fullName->toString());
    }

    public function testIsEqual()
    {
        $names = $this->generateNames();

        $fullName = new FullName(...$names);
        $fullNameEqual = new FullName(...$names);

        $this->assertTrue($fullName->isEqual($fullNameEqual));
    }

    public function testIsEqualWithNonEqualFirstName()
    {
        $names = $this->generateNames();
        $names_ = $this->generateNames();

        $fullName = new FullName(...$names);
        $fullNameNonEqualSecondName = new FullName($names_[0], $names[1]);

        $this->assertFalse($fullName->isEqual($fullNameNonEqualSecondName));
    }

    public function testIsEqualWithNonEqualLastName()
    {
        $names = $this->generateNames();
        $names_ = $this->generateNames();

        $fullName = new FullName(...$names);
        $fullNameNonEqual = new FullName($names[0], $names_[1]);

        $this->assertFalse($fullName->isEqual($fullNameNonEqual));
    }

    public function testFromString()
    {
        $names = $this->generateNames();

        $fullName = FullName::makeFromString($names[0].' '.$names[1]);
        $this->assertEquals($names[0], $fullName->getFirstName());
        $this->assertEquals($names[1], $fullName->getLastName());

        $this->assertEquals($names[0].' '.$names[1], $fullName->toString());
    }

    public function testFromStringWithException()
    {
        $faker = Factory::create();

        $this->expectException(InvalidArgumentException::class);
        FullName::makeFromString($faker->word);
    }

    public function testFromStringWithExceptionToManyWords()
    {
        $faker = Factory::create();

        $this->expectException(InvalidArgumentException::class);
        FullName::makeFromString(implode(' ', $faker->words(4)));
    }

    private function generateNames()
    {
        $faker = Factory::create();

        return [$faker->firstName, $faker->lastName];
    }
}
