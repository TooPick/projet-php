<?php

namespace PP\AppliBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Menu
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="PP\AppliBundle\Entity\MenuRepository")
 */
class Menu
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /** 
     * @ORM\ManyToOne(targetEntity="PP\UserBundle\Entity\Utilisateur")
     * @ORM\JoinColumn(nullable=false)
     */
    private $utilisateur;

    /**
     * @ORM\ManyToMany(targetEntity="PP\AppliBundle\Entity\Recette", cascade={"persist"})
     */
    private $recettes;

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
     * Set nom
     *
     * @param string $nom
     * @return Menu
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set utilisateur
     *
     * @param \PP\UserBundle\Entity\Utilisateur $utilisateur
     * @return Menu
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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->recettes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add recettes
     *
     * @param \PP\AppliBundle\Entity\Recette $recettes
     * @return Menu
     */
    public function addRecette(\PP\AppliBundle\Entity\Recette $recettes)
    {
        $this->recettes[] = $recettes;

        return $this;
    }

    /**
     * Remove recettes
     *
     * @param \PP\AppliBundle\Entity\Recette $recettes
     */
    public function removeRecette(\PP\AppliBundle\Entity\Recette $recettes)
    {
        $this->recettes->removeElement($recettes);
    }

    /**
     * Get recettes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRecettes()
    {
        return $this->recettes;
    }
}
