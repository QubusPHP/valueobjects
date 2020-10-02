<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Web;

use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\Structure\Dictionary;
use Qubus\ValueObjects\Web\QueryStringInterface;
use Qubus\ValueObjects\StringLiteral\StringLiteral;

class QueryString extends StringLiteral implements QueryStringInterface
{
    /**
     * Returns a new QueryString.
     *
     * @param string $value
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
     *
     * @return Dictionary
     */
    public function toDictionary(): Dictionary
    {
        $value = ltrim($this->toNative(), '?');
        parse_str($value, $data);

        return Dictionary::fromNative($data);
    }
}
