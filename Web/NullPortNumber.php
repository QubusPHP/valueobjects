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

use Qubus\ValueObjects\NullValue\NullValue;
use Qubus\ValueObjects\Web\PortNumber;

class NullPortNumber extends NullValue implements PortNumber
{
}
