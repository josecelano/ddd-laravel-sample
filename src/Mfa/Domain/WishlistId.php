<?php

namespace Mfa\Domain;

use Assert\Assertion;
use Ramsey\Uuid\Uuid;

class WishlistId
{
    /**
     * @var string
     */
    private $value;

    /**
     * @param string $value
     */
    public function __construct($value)
    {
        Assertion::string($value);
        Assertion::true(self::isValid($value), 'Invalid wishlist Id');

        $this->value = $value;
    }

    /**
     * @param string $value
     * @return WishlistId
     */
    public static function fromString($value)
    {
        return new self($value);
    }

    /**
     * @param $value
     * @return WishlistId
     */
    public static function create($value)
    {
        return new self($value);
    }

    /**
     * @return WishlistId
     */
    public static function generate()
    {
        return new self((string)Uuid::uuid4());
    }

    /**
     * @param string $value
     * @return bool
     */
    public static function isValid($value)
    {
        return Uuid::isValid($value);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->value;
    }

    /**
     * @param WishlistId $wishlistId
     * @return bool
     */
    public function equals(WishlistId $wishlistId)
    {
        if ($this->value === $wishlistId->getValue())
            return true;
        else
            return false;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return (string)$this->value;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return 'appliance';
    }
}