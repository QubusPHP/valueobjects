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

use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\StringLiteral\StringLiteral;

use function preg_match;
use function sprintf;

class SchemeName extends StringLiteral
{
    /**
     * Returns a SchemeName.
     */
    public function __construct(string $value)
    {
        if (0 === preg_match('/^[a-z]([a-z0-9\+\.-]+)?$/i', $value)) {
            throw new TypeException(
                sprintf(
                    'Argument "%s" is invalid. Must enter a string (valid scheme name).',
                    $value
                )
            );
        }

        $this->value = $value;
    }
}
