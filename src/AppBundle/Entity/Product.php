<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 */
class Product
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $designation;

    /**
     * @var string
     */
    private $eanCode;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set designation
     *
     * @param string $designation
     * @return Product
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * Get designation
     *
     * @return string 
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * Set eanCode
     *
     * @param string $eanCode
     * @return Product
     */
    public function setEanCode($eanCode)
    {
        $this->eanCode = $eanCode;

        return $this;
    }

    /**
     * Get eanCode
     *
     * @return string 
     */
    public function getEanCode()
    {
        return $this->eanCode;
    }
}
