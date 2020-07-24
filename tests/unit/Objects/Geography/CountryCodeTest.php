<?php
/**
 * CountryCodeTest.php
 *
 * @lastModification 22.07.2020, 00:37
 * @author Rafał Tadaszak <r.tadaszak@soit.pl>
 * @copyright soIT.pl 2018 - 2020
 * @url http://www.soit.pl
 */

namespace soIT\ValueObjects\Objects\Geography;

use Faker\Factory;
use Mockery;
use PHPUnit\Framework\TestCase;
use soIT\ValueObjects\Exceptions\InvalidArgumentException;
use soIT\ValueObjects\Exceptions\NotMatchTypeException;
use soIT\ValueObjects\ValueObjectInterface;

class CountryCodeTest extends TestCase
{
    /**
     * @throws NotMatchTypeException
     */
    public function testIsEqual()
    {
        $country = $this->generateCountry();

        $countryCode = CountryCode::makeFromString($country);
        $countryCodeEqual = CountryCode::makeFromString($country);

        $this->assertTrue($countryCode->isEqual($countryCodeEqual));
    }

    /**
     * @throws NotMatchTypeException
     */
    public function testIsEqualDifferentCountries()
    {
        $country = $this->generateCountry();
        do {
            $country_ = $this->generateCountry();
        } while ($country == $country_);

        $countryCode = CountryCode::makeFromString($country);
        $countryCodeEqual = CountryCode::makeFromString($country_);

        $this->assertFalse($countryCode->isEqual($countryCodeEqual));
    }

    /**
     * @throws NotMatchTypeException
     */
    public function testIsEqualDifferentObject()
    {
        $country = $this->generateCountry();

        $countryCode = CountryCode::makeFromString($country);
        $mock = Mockery::mock(ValueObjectInterface::class);

        $this->expectException(NotMatchTypeException::class);
        $countryCode->isEqual($mock);
    }

    public function testGet()
    {
        $country = $this->generateCountry();

        $countryCode = CountryCode::makeFromString($country);

        $this->assertEquals($country, $countryCode->get());
    }

    public function testMakeFromStringWrongString()
    {
        $this->expectException(InvalidArgumentException::class);
        CountryCode::makeFromString('XXXX');
    }

    public function testMakeFromStringNotUpperCase()
    {
        $this->expectException(InvalidArgumentException::class);
        CountryCode::makeFromString('pl');
    }

    public function testToString()
    {
        $country = $this->generateCountry();

        $countryCode = CountryCode::makeFromString($country);

        $this->assertEquals($country, $countryCode->toString());
    }

    private function generateCountry():string
    {
        $faker = Factory::create();

        return $faker->countryCode;
    }
}
