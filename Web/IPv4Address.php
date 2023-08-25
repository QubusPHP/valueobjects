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

namespace Qubus\ValueObjects\Web;

use Qubus\Exception\Data\TypeException;

use function filter_var;
use function sprintf;

use const FILTER_FLAG_IPV4;
use const FILTER_VALIDATE_IP;

class IPv4Address extends IPAddress
{
    /**
     * Returns a new IPv4Address
     * @throws TypeException
     */
    public function __construct(string $value)
    {
        $filteredValue = filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);

        if (false === $filteredValue) {
            throw new TypeException(
                sprintf(
                    'Argument "%s" is invalid. Must enter a string (valid ipv4 address).',
                    $value
                )
            );
        }

        $this->value = $filteredValue;
    }
}
