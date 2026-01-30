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

namespace Qubus\ValueObjects\Geography;

use Qubus\ValueObjects\Enum\Enum;

/**
 * @method static string AIRY()
 * @method static string AUSTRALIAN_NATIONAL()
 * @method static string BESSEL_1841()
 * @method static string BESSEL_1841_NAMBIA()
 * @method static string CLARKE_1866()
 * @method static string CLARKE_1880()
 * @method static string EVEREST()
 * @method static string FISCHER_1960_MERCURY()
 * @method static string FISCHER_1968()
 * @method static string GRS_1967()
 * @method static string GRS_1980()
 * @method static string HELMERT_1906()
 * @method static string HOUGH()
 * @method static string INTERNATIONAL()
 * @method static string KRASSOVSKY()
 * @method static string MODIFIED_AIRY()
 * @method static string MODIFIED_EVEREST()
 * @method static string MODIFIED_FISCHER_1960()
 * @method static string SOUTH_AMERICAN_1969()
 * @method static string WGS60()
 * @method static string WGS66()
 * @method static string WGS72()
 * @method static string WGS84()
 */
class Ellipsoid extends Enum
{
    public const string AIRY = 'AIRY';
    public const string AUSTRALIAN_NATIONAL = 'AUSTRALIAN_NATIONAL';
    public const string BESSEL_1841 = 'BESSEL_1841';
    public const string BESSEL_1841_NAMBIA = 'BESSEL_1841_NAMBIA';
    public const string CLARKE_1866 = 'CLARKE_1866';
    public const string CLARKE_1880 = 'CLARKE_1880';
    public const string EVEREST = 'EVEREST';
    public const string FISCHER_1960_MERCURY = 'FISCHER_1960_MERCURY';
    public const string FISCHER_1968 = 'FISCHER_1968';
    public const string GRS_1967 = 'GRS_1967';
    public const string GRS_1980 = 'GRS_1980';
    public const string HELMERT_1906 = 'HELMERT_1906';
    public const string HOUGH = 'HOUGH';
    public const string INTERNATIONAL = 'INTERNATIONAL';
    public const string KRASSOVSKY = 'KRASSOVSKY';
    public const string MODIFIED_AIRY = 'MODIFIED_AIRY';
    public const string MODIFIED_EVEREST = 'MODIFIED_EVEREST';
    public const string MODIFIED_FISCHER_1960 = 'MODIFIED_FISCHER_1960';
    public const string SOUTH_AMERICAN_1969 = 'SOUTH_AMERICAN_1969';
    public const string WGS60 = 'WGS60';
    public const string WGS66 = 'WGS66';
    public const string WGS72 = 'WGS72';
    public const string WGS84 = 'WGS84';
}
