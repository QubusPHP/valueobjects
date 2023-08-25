<?php

/**
 * Qubus\ValueObjects
 *
 * @link       https://github.com/QubusPHP/valueobjects
 * @copyright  2020
 * @author     Joshua Parker <joshua@joshuaparker.dev>
 * @license    https://opensource.org/licenses/mit-license.php MIT License
 */

declare(strict_types=1);

namespace Qubus\ValueObjects\DateTime\Exception;

use Qubus\Exception\BaseException;
use Qubus\Exception\Exception;

use function sprintf;

final class InvalidTimeZoneException extends Exception
{
    /**
     * @var string $name
     * @throws BaseException
     */
    public function __construct($name)
    {
        $message = sprintf(
            'The timezone "%s" is invalid. Check "timezone_identifiers_list()" for valid values.',
            $name
        );
        parent::__construct($message);
    }
}
