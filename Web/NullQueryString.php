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

use Qubus\ValueObjects\Web\QueryString;
use Qubus\ValueObjects\Web\UrlQueryString;

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
