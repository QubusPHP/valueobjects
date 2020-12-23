<?php

/**
 * Qubus\ValueObjects
 *
 * @link       https://github.com/QubusPHP/valueobjects
 * @copyright  2020 Joshua Parker
 * @license    https://opensource.org/licenses/mit-license.php MIT License
 *
 * @since      1.0.0
 */

declare(strict_types=1);

namespace Qubus\ValueObjects\Web;

use Qubus\ValueObjects\StringLiteral\StringLiteral;
use Qubus\ValueObjects\Web\Hostname;
use Qubus\ValueObjects\Web\IPAddress;

use function filter_var;

use const FILTER_VALIDATE_IP;

abstract class Domain extends StringLiteral
{
    /**
     * Returns a Hostname or a IPAddress object depending on passed value
     *
     * @param  $domain
     * @return Hostname|IPAddress
     */
    public static function specifyType($domain)
    {
        if (false !== filter_var($domain, FILTER_VALIDATE_IP)) {
            return new IPAddress($domain);
        }

        return new Hostname($domain);
    }
}
