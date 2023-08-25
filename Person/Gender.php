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

namespace Qubus\ValueObjects\Person;

use Qubus\ValueObjects\Enum\Enum;

/**
 * @method static string MALE()
 * @method static string FEMALE()
 * @method static string CISGENDER()
 * @method static string NONBINARY()
 * @method static string OTHER()
 */
class Gender extends Enum
{
    public const MALE = 'male';
    public const FEMALE = 'female';
    public const CISGENDER = 'cisgender';
    public const NONBINARY = 'non-binary';
    public const OTHER = 'other';
}
