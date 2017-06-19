<?php

namespace Mfa\Domain;

use League\Event\GeneratorInterface;
use League\Event\GeneratorTrait;
use Mfa\Domain\Event\ApplianceWasUpdated;
use Money\Money;

class Appliance implements GeneratorInterface
{
    use GeneratorTrait;

    /** @var  ApplianceId */
    private $id;

    /** @var  string */
    private $externalId;

    /** @var  ApplianceDescription */
    private $description;

    /** @var  string */
    private $image;

    /** @var  ApplianceCategory */
    private $category;

    /** @var  Money */
    private $price;

    /**
     * Appliance constructor.
     * @param ApplianceId $id
     * @param string $externalId
     * @param ApplianceDescription $description
     * @param string $image
     * @param ApplianceCategory $category
     * @param Money $price
     */
    public function __construct(
        ApplianceId $id,
        $externalId,
        ApplianceDescription $description,
        $image,
        ApplianceCategory $category,
        Money $price
    )
    {
        $this->id = $id;
        $this->externalId = $externalId;
        $this->description = $description;
        $this->image = $image;
        $this->category = $category;
        $this->price = $price;

        $this->addEvent(new ApplianceWasUpdated($this));
    }

    /**
     * @param $externalId
     * @param ApplianceDescription $description
     * @param string $image
     * @param ApplianceCategory $category
     * @param Money $price
     */
    public function update(
        $externalId,
        ApplianceDescription $description,
        $image,
        ApplianceCategory $category,
        Money $price
    )
    {
        $this->externalId = $externalId;
        $this->description = $description;
        $this->image = $image;
        $this->category = $category;
        $this->price = $price;

        $this->addEvent(new ApplianceWasUpdated($this));
    }

    /**
     * @return ApplianceId
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getExternalId()
    {
        return $this->externalId;
    }

    /**
     * @return ApplianceDescription
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return ApplianceCategory
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return Money
     */
    public function getPrice()
    {
        return $this->price;
    }
}