<?php

/**
 * Qubus\ValueObjects
 *
 * @link       https://github.com/QubusPHP/valueobjects
 *
 * @since      1.0.0
 */

declare(strict_types=1);

namespace Qubus\ValueObjects\Web;

use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\StringLiteral\StringLiteral;
use Qubus\ValueObjects\Structure\Dictionary;
use Qubus\ValueObjects\Web\QueryString;

use function ltrim;
use function parse_str;
use function preg_match;
use function sprintf;

class UrlQueryString extends StringLiteral implements QueryString
{
    /**
     * Returns a new QueryString.
     */
    public function __construct(string $value)
    {
        if (0 === preg_match('/^\?([\w\.\-[\]~&%+]+(=([\w\.\-~&%+]+)?)?)*$/', $value)) {
            throw new TypeException(
                sprintf(
                    'Argument "%s" is invalid. Must enter a string (valid query string).',
                    $value
                )
            );
        }

        $this->value = $value;
    }

    /**
     * Returns a Dictionary structured representation of the query string.
     */
    public function toDictionary(): Dictionary
    {
        $value = ltrim($this->toNative(), '?');
        parse_str($value, $data);

        return Dictionary::fromNative($data);
    }
}
