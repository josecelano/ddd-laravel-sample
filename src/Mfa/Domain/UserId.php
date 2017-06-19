<?php

namespace Mfa\Domain;

use Assert\Assertion;

class UserId
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
        Assertion::true(self::isValid($value));

        $this->value = $value;
    }

    /**
     * @param string $value
     * @return UserId
     */
    public static function fromString($value)
    {
        return new self($value);
    }

    /**
     * @param string $value
     * @return UserId
     */
    public static function fromInteger($value)
    {
        return new self((string)$value);
    }

    /**
     * @param $value
     * @return UserId
     */
    public static function create($value)
    {
        return new self($value);
    }

    /**
     * @param string $value
     * @return bool
     */
    public static function isValid($value)
    {
        return is_numeric($value) && floor($value) == $value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->value;
    }

    /**
     * @param UserId $userId
     * @return bool
     */
    public function equals(UserId $userId)
    {
        if ($this->value === $userId->getValue())
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
        return 'user';
    }
}