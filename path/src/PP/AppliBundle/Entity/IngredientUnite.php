<?php

namespace PP\AppliBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IngredientUnite
 *
 * @ORM\Table(name="ingredient_unite")
 * @ORM\Entity(repositoryClass="PP\AppliBundle\Entity\IngredientUniteRepository")
 */
class IngredientUnite
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** 
     * @ORM\ManyToOne(targetEntity="PP\AppliBundle\Entity\Ingredient")
     * @ORM\JoinColumn(nullable=true)
     */
    private $ingredient;

    /** 
     * @ORM\ManyToOne(targetEntity="PP\AppliBundle\Entity\Unite")
     * @ORM\JoinColumn(nullable=true)
     */
    private $unite;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantite", type="integer", nullable=true)
     */
    private $quantite;


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
     * Set ingredient
     *
     * @param \PP\AppliBundle\Entity\Ingredient $ingredient
     * @return IngredientUnite
     */
    public function setIngredient(\PP\AppliBundle\Entity\Ingredient $ingredient = null)
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    /**
     * Get ingredient
     *
     * @return \PP\AppliBundle\Entity\Ingredient 
     */
    public function getIngredient()
    {
        return $this->ingredient;
    }

    /**
     * Set unite
     *
     * @param \PP\AppliBundle\Entity\Unite $unite
     * @return IngredientUnite
     */
    public function setUnite(\PP\AppliBundle\Entity\Unite $unite = null)
    {
        $this->unite = $unite;

        return $this;
    }

    /**
     * Get unite
     *
     * @return \PP\AppliBundle\Entity\Unite 
     */
    public function getUnite()
    {
        return $this->unite;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     * @return IngredientUnite
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return integer 
     */
    public function getQuantite()
    {
        return $this->quantite;
    }
}
