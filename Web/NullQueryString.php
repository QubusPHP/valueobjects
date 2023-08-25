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

class NullQueryString extends UrlQueryString implements QueryString
{
    /**
     * Returns a new NullQueryString.
     */
    public function __construct()
    {
        $this->value = '';
    }
}
