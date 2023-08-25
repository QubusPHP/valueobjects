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

use function sprintf;

class Hostname extends Domain
{
    use ValidateHostnameAware;
    /**
     * Returns a Hostname
     * @throws TypeException
     */
    public function __construct(string $value)
    {
        if (false === $this->isValid($value)) {
            throw new TypeException(
                sprintf(
                    'Argument "%s" is invalid. Must enter a string (valid hostname).',
                    $value
                )
            );
        }

        $this->value = $value;
    }
}
