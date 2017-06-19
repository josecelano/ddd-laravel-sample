<?php

namespace Mfa\Domain;

use Assert\Assertion;
use Ramsey\Uuid\Uuid;

class ApplianceId
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
        Assertion::true(self::isValid($value), 'Invalid appliance Id');

        $this->value = $value;
    }

    /**
     * @param string $value
     * @return ApplianceId
     */
    public static function fromString($value)
    {
        return new self($value);
    }

    /**
     * @param $value
     * @return ApplianceId
     */
    public static function create($value)
    {
        return new self($value);
    }

    /**
     * @return ApplianceId
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
     * @param array $applianceIds
     * @return ApplianceIdCollection
     */
    public static function collection(array $applianceIds = [])
    {
        return ApplianceIdCollection::build($applianceIds);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->value;
    }

    /**
     * @param ApplianceId $applianceId
     * @return bool
     */
    public function equals(ApplianceId $applianceId)
    {
        if ($this->value === $applianceId->getValue())
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