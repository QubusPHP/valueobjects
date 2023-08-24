<?php

/**
 * Qubus\ValueObjects
 *
 * @link       https://github.com/QubusPHP/valueobjects
 * @copyright  2020
 * @author     Joshua Parker <joshua@joshuaparker.dev>
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

class UrlFragmentIdentifier extends StringLiteral implements FragmentIdentifier
{
    /**
     * Returns a new FragmentIdentifier.
     * @throws TypeException
     */
    public function __construct(string $value)
    {
        if (0 === preg_match('/^#[?%!$&\'()*+,;=a-zA-Z0-9-._~:@\/]*$/', $value)) {
            throw new TypeException(
                sprintf(
                    'Argument "%s" is invalid. Must enter a string (valid fragment identifier).',
                    $value
                )
            );
        }

        $this->value = $value;
    }
}
