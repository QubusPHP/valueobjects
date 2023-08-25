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

trait ValidateHostnameAware
{
    protected function isValid(string $domain): bool
    {
        if (filter_var(gethostbyname($domain), FILTER_VALIDATE_IP)) {
            return true;
        }

        return false;
    }
}
