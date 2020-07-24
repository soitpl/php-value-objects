<?php
/**
 * Minutes.php
 *
 * @lastModification 22.07.2020, 00:35
 * @author Rafał Tadaszak <r.tadaszak@soit.pl>
 * @copyright soIT.pl 2018 - 2020
 * @url http://www.soit.pl
 */

namespace soIT\ValueObjects\Objects\DateTime\Unit;

use soIT\ValueObjects\ValueObjectInterface;

final class Minutes extends UnitAbstract implements ValueObjectInterface
{
    public const RANGE = ['min' => 0, "max" => 59];
}
