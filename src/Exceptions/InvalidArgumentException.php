<?php
/**
 * InvalidArgumentException.php
 *
 * @lastModification 22.07.2020, 00:37
 * @author Rafał Tadaszak <r.tadaszak@soit.pl>
 * @copyright soIT.pl 2018 - 2020
 * @url http://www.soit.pl
 */

namespace soIT\ValueObjects\Exceptions;

/**
 * Invalid attribute class for ValueObjects
 *
 * @package Core\Shared\ValueObjects\Exceptions
 * @author Rafał Tadaszak <r.tadaszak@soit.pl>
 */
class InvalidArgumentException extends \InvalidArgumentException
{
    /**
     * InvalidArgumentException constructor.
     *
     * @param string $className Class name
     * @param mixed $value Given value
     * @param string $message Additional message
     */
    public function __construct(string $className, $value, ?string $message = null)
    {
        $this->message = sprintf(
            'Given argument "%s" is invalid for %s',
            $value,
            $className
        );

        if ($message) {
            $this->message .= ': '.$message;
        }

        parent::__construct();
    }
}
