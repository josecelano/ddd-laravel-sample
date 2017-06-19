<?php

namespace Mfa\Application\Command;

class UpdateOrCreateApplianceCommand
{
    /** @var string */
    private $applianceId;

    /** @var int */
    private $externalId;

    /** @var string */
    private $title;

    /** @var string */
    private $description;

    /** @var string */
    private $productUrl;

    /** @var string */
    private $image;

    /** @var string */
    private $imageUrl;

    /** @var string */
    private $category;

    /** @var int */
    private $priceAmount;

    /** @var string */
    private $priceCurrency;

    /**
     * UpdateOrCreateAppliance constructor.
     * @param string $applianceId
     * @param int $externalId
     * @param string $title
     * @param string $description
     * @param string $productUrl
     * @param string $image
     * @param string $imageUrl
     * @param string $category
     * @param int $priceAmount
     * @param string $priceCurrency
     */
    public function __construct(
        $applianceId,
        $externalId,
        $title,
        $description,
        $productUrl,
        $image,
        $imageUrl,
        $category,
        $priceAmount,
        $priceCurrency
    )
    {
        $this->applianceId = $applianceId;
        $this->externalId = $externalId;
        $this->title = $title;
        $this->description = $description;
        $this->productUrl = $productUrl;
        $this->image = $image;
        $this->imageUrl = $imageUrl;
        $this->category = $category;
        $this->priceAmount = $priceAmount;
        $this->priceCurrency = $priceCurrency;
    }

    /**
     * @param array $data
     * @return UpdateOrCreateApplianceCommand
     */
    public static function fromData(array $data)
    {
        $createApplianceCommand = new self(
            $data['appliance_id'],
            $data['external_id'],
            $data['title'],
            $data['description'],
            $data['product_url'],
            $data['image'],
            $data['image_url'],
            $data['category'],
            $data['price_amount'],
            $data['price_currency']
        );
        return $createApplianceCommand;
    }

    /**
     * @return string
     */
    public function getApplianceId()
    {
        return $this->applianceId;
    }

    /**
     * @return int
     */
    public function getExternalId()
    {
        return $this->externalId;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getProductUrl()
    {
        return $this->productUrl;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return int
     */
    public function getPriceAmount()
    {
        return $this->priceAmount;
    }

    /**
     * @return string
     */
    public function getPriceCurrency()
    {
        return $this->priceCurrency;
    }
}