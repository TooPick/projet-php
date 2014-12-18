<?php

namespace PP\AppliBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ingredient
 *
 * @ORM\Table(name="t_ingredient_igd")
 * @ORM\Entity(repositoryClass="PP\AppliBundle\Entity\IngredientRepository")
 */
class Ingredient
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
     * @var string
     *
     * @ORM\Column(name="igd_label", type="string", length=255)
     */
    private $igdLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="igd_description", type="text")
     */
    private $igdDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="igd_illustration", type="string", length=80)
     */
    private $igdIllustration;

    /**
     * @var boolean
     *
     * @ORM\Column(name="igd_valide", type="boolean")
     */
    private $igdValide;

    /** 
     * @ORM\ManyToOne(targetEntity="PP\UserBundle\Entity\Utilisateur")
     * @ORM\JoinColumn(nullable=false)
     */
    private $utilisateur;    

    public function __construct()
    {
        $this->setIgdValide(0);
    }


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
     * Set igdLabel
     *
     * @param string $igdLabel
     * @return Ingredient
     */
    public function setIgdLabel($igdLabel)
    {
        $this->igdLabel = $igdLabel;

        return $this;
    }

    /**
     * Get igdLabel
     *
     * @return string 
     */
    public function getIgdLabel()
    {
        return $this->igdLabel;
    }

    /**
     * Set igdDescription
     *
     * @param string $igdDescription
     * @return Ingredient
     */
    public function setIgdDescription($igdDescription)
    {
        $this->igdDescription = $igdDescription;

        return $this;
    }

    /**
     * Get igdDescription
     *
     * @return string 
     */
    public function getIgdDescription()
    {
        return $this->igdDescription;
    }

    /**
     * Set igdIllustration
     *
     * @param string $igdIllustration
     * @return Ingredient
     */
    public function setIgdIllustration($igdIllustration)
    {
        $this->igdIllustration = $igdIllustration;

        return $this;
    }

    /**
     * Get igdIllustration
     *
     * @return string 
     */
    public function getIgdIllustration()
    {
        return $this->igdIllustration;
    }

    /**
     * Set igdValide
     *
     * @param boolean $igdValide
     * @return Ingredient
     */
    public function setIgdValide($igdValide)
    {
        $this->igdValide = $igdValide;

        return $this;
    }

    /**
     * Get igdValide
     *
     * @return boolean 
     */
    public function getIgdValide()
    {
        return $this->igdValide;
    }


    /**
     * Set utilisateur
     *
     * @param \PP\UserBundle\Entity\Utilisateur $utilisateur
     * @return Ingredient
     */
    public function setUtilisateur(\PP\UserBundle\Entity\Utilisateur $utilisateur)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return \PP\UserBundle\Entity\Utilisateur 
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }
}
