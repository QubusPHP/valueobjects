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
    public const string MALE = 'male';
    public const string FEMALE = 'female';
    public const string CISGENDER = 'cisgender';
    public const string NONBINARY = 'non-binary';
    public const string OTHER = 'other';
}
