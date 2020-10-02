<?php

declare(strict_types=1);

namespace Qubus\ValueObjects\Identity;

use Qubus\ValueObjects\Util;
use Ramsey\Uuid\Uuid as BaseUuid;
use Qubus\Exception\Data\TypeException;
use Qubus\ValueObjects\ValueObjectInterface;
use Qubus\ValueObjects\StringLiteral\StringLiteral;

class UUID extends StringLiteral
{
    /**
     * @var BaseUuid
     */
    protected $value;

    /**
     * UUID constructor.
     *
     * @param string|null $value
     */
    public function __construct(string $value = null)
    {
        $uuid_str = BaseUuid::uuid4();

        if (null !== $value) {
            $pattern = '/'.BaseUuid::VALID_PATTERN.'/';

            if (!preg_match($pattern, $value)) {
                throw new TypeException(
                    sprintf(
                        'Argument "%s" is invalid. UUID must be a string.',
                        $value
                    )
                );
            }

            $uuid_str = $value;
        }

        $this->value = strval($uuid_str);
    }

    /**
     * @param string $uuid
     *
     * @throws \Qubus\Exception\TypeException
     * @return UUID|ValueObjectInterface
     */
    public static function fromNative(): ValueObjectInterface
    {
        $uuid_str = func_get_arg(0);
        $uuid = new static($uuid_str);

        return $uuid;
    }

    /**
     * Generate a new UUID string.
     *
     * @return string
     */
    public static function generateAsString(): string
    {
        $uuid = new static();
        $uuidString = $uuid->toNative();

        return $uuidString;
    }

    /**
     * Tells whether two UUID are equal by comparing their values.
     *
     * @param  UUID|ValueObjectInterface $uuid
     * @return bool
     */
    public function equals(ValueObjectInterface $uuid): bool
    {
        if (false === Util::classEquals($this, $uuid)) {
            return false;
        }

        return $this->toNative() === $uuid->toNative();
    }
}
