<?php

namespace Mfa\Domain;

use Mockery\Exception;

class ApplianceCategory
{
    CONST DISHWASHER = 'dishwasher';
    CONST SMALL_APPLIANCE = 'small_appliance';

    /** @var  string */
    private $name;

    /**
     * @param $category
     * @return ApplianceCategory
     */
    public static function fromName($category)
    {
        self::validate($category);
        return new self($category);
    }

    /**
     * @param string $category
     */
    public static function validate($category)
    {
        if (!in_array($category, self::categoryNames())) {
            throw new Exception(sprintf('Invalid category name %s', $category));
        };
    }

    /**
     * @return array
     */
    public static function categoryNames()
    {
        return [
            self::DISHWASHER,
            self::SMALL_APPLIANCE
        ];
    }

    /**
     * ApplianceCategory constructor.
     * @param string $name
     */
    private function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return ApplianceCategory
     */
    public static function dishwasher()
    {
        return new self(self::DISHWASHER);
    }

    /**
     * @return ApplianceCategory
     */
    public static function smallAppliance()
    {
        return new self(self::SMALL_APPLIANCE);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
