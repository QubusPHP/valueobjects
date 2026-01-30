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

namespace Qubus\ValueObjects\Web;

use Qubus\Exception\Data\TypeException;

class NullFragmentIdentifier extends UrlFragmentIdentifier implements FragmentIdentifier
{
    /**
     * Returns a new NullFragmentIdentifier.
     *
     * @throws TypeException
     */
    public function __construct(protected string $value = '')
    {
        parent::__construct($value);
    }
}
