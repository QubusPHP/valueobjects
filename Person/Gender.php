<?php

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
    const MALE = 'male';
    const FEMALE = 'female';
    const CISGENDER = 'cisgender';
    const NONBINARY = 'non-binary';
    const OTHER = 'other';
}
