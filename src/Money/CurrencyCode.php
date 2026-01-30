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

namespace Qubus\ValueObjects\Money;

use Qubus\ValueObjects\Enum\Enum;

/**
 * @method static string AED()
 * @method static string AFN()
 * @method static string ALL()
 * @method static string AMD()
 * @method static string ANG()
 * @method static string AOA()
 * @method static string ARS()
 * @method static string AUD()
 * @method static string AWG()
 * @method static string AZN()
 * @method static string BAM()
 * @method static string BBD()
 * @method static string BDT()
 * @method static string BGN()
 * @method static string BHD()
 * @method static string BIF()
 * @method static string BMD()
 * @method static string BND()
 * @method static string BOB()
 * @method static string BRL()
 * @method static string BSD()
 * @method static string BTN()
 * @method static string BWP()
 * @method static string BYR()
 * @method static string BZD()
 * @method static string CAD()
 * @method static string CDF()
 * @method static string CHF()
 * @method static string CLF()
 * @method static string CLP()
 * @method static string CNY()
 * @method static string COP()
 * @method static string CRC()
 * @method static string CUP()
 * @method static string CVE()
 * @method static string CZK()
 * @method static string DJF()
 * @method static string DKK()
 * @method static string DOP()
 * @method static string DZD()
 * @method static string EEK()
 * @method static string EGP()
 * @method static string ETB()
 * @method static string EUR()
 * @method static string FJD()
 * @method static string FKP()
 * @method static string GBP()
 * @method static string GEL()
 * @method static string GHS()
 * @method static string GIP()
 * @method static string GMD()
 * @method static string GNF()
 * @method static string GTQ()
 * @method static string GYD()
 * @method static string HKD()
 * @method static string HNL()
 * @method static string HRK()
 * @method static string HTG()
 * @method static string HUF()
 * @method static string IDR()
 * @method static string ILS()
 * @method static string INR()
 * @method static string IQD()
 * @method static string IRR()
 * @method static string ISK()
 * @method static string JEP()
 * @method static string JMD()
 * @method static string JOD()
 * @method static string JPY()
 * @method static string KES()
 * @method static string KGS()
 * @method static string KHR()
 * @method static string KMF()
 * @method static string KPW()
 * @method static string KRW()
 * @method static string KWD()
 * @method static string KYD()
 * @method static string KZT()
 * @method static string LAK()
 * @method static string LBP()
 * @method static string LKR()
 * @method static string LRD()
 * @method static string LSL()
 * @method static string LTL()
 * @method static string LVL()
 * @method static string LYD()
 * @method static string MAD()
 * @method static string MDL()
 * @method static string MGA()
 * @method static string MKD()
 * @method static string MMK()
 * @method static string MNT()
 * @method static string MOP()
 * @method static string MRO()
 * @method static string MUR()
 * @method static string MVR()
 * @method static string MWK()
 * @method static string MXN()
 * @method static string MYR()
 * @method static string MZN()
 * @method static string NAD()
 * @method static string NGN()
 * @method static string NIO()
 * @method static string NOK()
 * @method static string NPR()
 * @method static string NZD()
 * @method static string OMR()
 * @method static string PAB()
 * @method static string PEN()
 * @method static string PGK()
 * @method static string PHP()
 * @method static string PKR()
 * @method static string PLN()
 * @method static string PYG()
 * @method static string QAR()
 * @method static string RON()
 * @method static string RSD()
 * @method static string RUB()
 * @method static string RWF()
 * @method static string SAR()
 * @method static string SBD()
 * @method static string SCR()
 * @method static string SDG()
 * @method static string SEK()
 * @method static string SGD()
 * @method static string SHP()
 * @method static string SLL()
 * @method static string SOS()
 * @method static string SRD()
 * @method static string STD()
 * @method static string SVC()
 * @method static string SYP()
 * @method static string SZL()
 * @method static string THB()
 * @method static string TJS()
 * @method static string TMT()
 * @method static string TND()
 * @method static string TOP()
 * @method static string TRY_()
 * @method static string TTD()
 * @method static string TWD()
 * @method static string TZS()
 * @method static string UAH()
 * @method static string UGX()
 * @method static string USD()
 * @method static string UYU()
 * @method static string UZS()
 * @method static string VEF()
 * @method static string VND()
 * @method static string VUV()
 * @method static string WST()
 * @method static string XAF()
 * @method static string XCD()
 * @method static string XDR()
 * @method static string XOF()
 * @method static string XPF()
 * @method static string YER()
 * @method static string ZAR()
 * @method static string ZMK()
 * @method static string ZWL()
 */
class CurrencyCode extends Enum
{
    public const string AED = 'AED';
    public const string AFN = 'AFN';
    public const string ALL = 'ALL';
    public const string AMD = 'AMD';
    public const string ANG = 'ANG';
    public const string AOA = 'AOA';
    public const string ARS = 'ARS';
    public const string AUD = 'AUD';
    public const string AWG = 'AWG';
    public const string AZN = 'AZN';
    public const string BAM = 'BAM';
    public const string BBD = 'BBD';
    public const string BDT = 'BDT';
    public const string BGN = 'BGN';
    public const string BHD = 'BHD';
    public const string BIF = 'BIF';
    public const string BMD = 'BMD';
    public const string BND = 'BND';
    public const string BOB = 'BOB';
    public const string BRL = 'BRL';
    public const string BSD = 'BSD';
    public const string BTN = 'BTN';
    public const string BWP = 'BWP';
    public const string BYR = 'BYR';
    public const string BZD = 'BZD';
    public const string CAD = 'CAD';
    public const string CDF = 'CDF';
    public const string CHF = 'CHF';
    public const string CLF = 'CLF';
    public const string CLP = 'CLP';
    public const string CNY = 'CNY';
    public const string COP = 'COP';
    public const string CRC = 'CRC';
    public const string CUP = 'CUP';
    public const string CVE = 'CVE';
    public const string CZK = 'CZK';
    public const string DJF = 'DJF';
    public const string DKK = 'DKK';
    public const string DOP = 'DOP';
    public const string DZD = 'DZD';
    public const string EEK = 'EEK';
    public const string EGP = 'EGP';
    public const string ETB = 'ETB';
    public const string EUR = 'EUR';
    public const string FJD = 'FJD';
    public const string FKP = 'FKP';
    public const string GBP = 'GBP';
    public const string GEL = 'GEL';
    public const string GHS = 'GHS';
    public const string GIP = 'GIP';
    public const string GMD = 'GMD';
    public const string GNF = 'GNF';
    public const string GTQ = 'GTQ';
    public const string GYD = 'GYD';
    public const string HKD = 'HKD';
    public const string HNL = 'HNL';
    public const string HRK = 'HRK';
    public const string HTG = 'HTG';
    public const string HUF = 'HUF';
    public const string IDR = 'IDR';
    public const string ILS = 'ILS';
    public const string INR = 'INR';
    public const string IQD = 'IQD';
    public const string IRR = 'IRR';
    public const string ISK = 'ISK';
    public const string JEP = 'JEP';
    public const string JMD = 'JMD';
    public const string JOD = 'JOD';
    public const string JPY = 'JPY';
    public const string KES = 'KES';
    public const string KGS = 'KGS';
    public const string KHR = 'KHR';
    public const string KMF = 'KMF';
    public const string KPW = 'KPW';
    public const string KRW = 'KRW';
    public const string KWD = 'KWD';
    public const string KYD = 'KYD';
    public const string KZT = 'KZT';
    public const string LAK = 'LAK';
    public const string LBP = 'LBP';
    public const string LKR = 'LKR';
    public const string LRD = 'LRD';
    public const string LSL = 'LSL';
    public const string LTL = 'LTL';
    public const string LVL = 'LVL';
    public const string LYD = 'LYD';
    public const string MAD = 'MAD';
    public const string MDL = 'MDL';
    public const string MGA = 'MGA';
    public const string MKD = 'MKD';
    public const string MMK = 'MMK';
    public const string MNT = 'MNT';
    public const string MOP = 'MOP';
    public const string MRO = 'MRO';
    public const string MUR = 'MUR';
    public const string MVR = 'MVR';
    public const string MWK = 'MWK';
    public const string MXN = 'MXN';
    public const string MYR = 'MYR';
    public const string MZN = 'MZN';
    public const string NAD = 'NAD';
    public const string NGN = 'NGN';
    public const string NIO = 'NIO';
    public const string NOK = 'NOK';
    public const string NPR = 'NPR';
    public const string NZD = 'NZD';
    public const string OMR = 'OMR';
    public const string PAB = 'PAB';
    public const string PEN = 'PEN';
    public const string PGK = 'PGK';
    public const string PHP = 'PHP';
    public const string PKR = 'PKR';
    public const string PLN = 'PLN';
    public const string PYG = 'PYG';
    public const string QAR = 'QAR';
    public const string RON = 'RON';
    public const string RSD = 'RSD';
    public const string RUB = 'RUB';
    public const string RWF = 'RWF';
    public const string SAR = 'SAR';
    public const string SBD = 'SBD';
    public const string SCR = 'SCR';
    public const string SDG = 'SDG';
    public const string SEK = 'SEK';
    public const string SGD = 'SGD';
    public const string SHP = 'SHP';
    public const string SLL = 'SLL';
    public const string SOS = 'SOS';
    public const string SRD = 'SRD';
    public const string STD = 'STD';
    public const string SVC = 'SVC';
    public const string SYP = 'SYP';
    public const string SZL = 'SZL';
    public const string THB = 'THB';
    public const string TJS = 'TJS';
    public const string TMT = 'TMT';
    public const string TND = 'TND';
    public const string TOP = 'TOP';
    public const string TRY_ = 'TRY'; // "try" is a PHP reserved word
    public const string TTD = 'TTD';
    public const string TWD = 'TWD';
    public const string TZS = 'TZS';
    public const string UAH = 'UAH';
    public const string UGX = 'UGX';
    public const string USD = 'USD';
    public const string UYU = 'UYU';
    public const string UZS = 'UZS';
    public const string VEF = 'VEF';
    public const string VND = 'VND';
    public const string VUV = 'VUV';
    public const string WST = 'WST';
    public const string XAF = 'XAF';
    public const string XCD = 'XCD';
    public const string XDR = 'XDR';
    public const string XOF = 'XOF';
    public const string XPF = 'XPF';
    public const string YER = 'YER';
    public const string ZAR = 'ZAR';
    public const string ZMK = 'ZMK';
    public const string ZWL = 'ZWL';
}
