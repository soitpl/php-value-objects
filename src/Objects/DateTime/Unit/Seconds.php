<?php
/**
 * Seconds.php
 *
 * @lastModification 30.12.2019, 11:01
 * @author Rafał Tadaszak <r.tadaszak@soit.pl>
 * @copyright soIT.pl 2018 - 2020
 * @url http://www.soit.pl
 */

namespace soIT\ValueObjects\Objects\DateTime\Unit;

use soIT\ValueObjects\ValueObjectInterface;

final class Seconds extends UnitAbstract implements ValueObjectInterface
{
    public const RANGE = ['min' => 0, "max" => 60];
}
