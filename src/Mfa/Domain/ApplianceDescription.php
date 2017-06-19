<?php

namespace Mfa\Domain;

class ApplianceDescription
{
    /** @var  string */
    private $title;

    /** @var  string */
    private $description;

    /**
     * ApplianceDescription constructor.
     * @param string $title
     * @param string $description
     */
    public function __construct($title, $description)
    {
        $this->title = $title;
        $this->description = $description;
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
}