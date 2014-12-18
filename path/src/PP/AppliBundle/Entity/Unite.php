<?php

namespace PP\AppliBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Unite
 *
 * @ORM\Table(name="t_unite_uni")
 * @ORM\Entity(repositoryClass="PP\AppliBundle\Entity\UniteRepository")
 */
class Unite
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
     * @ORM\Column(name="uni_label", type="string", length=30)
     */
    private $uniLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="uni_short_label", type="string", length=15)
     */
    private $uniShortLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="uni_description", type="text")
     */
    private $uniDescription;

    /**
     * @var boolean
     *
     * @ORM\Column(name="uni_valide", type="boolean")
     */
    private $uniValide;

    /** 
     * @ORM\ManyToOne(targetEntity="PP\UserBundle\Entity\Utilisateur")
     * @ORM\JoinColumn(nullable=false)
     */
    private $utilisateur;

    public function __construct()
    {
        $this->setUniValide(0);
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
     * Set uniLabel
     *
     * @param string $uniLabel
     * @return Unite
     */
    public function setUniLabel($uniLabel)
    {
        $this->uniLabel = $uniLabel;

        return $this;
    }

    /**
     * Get uniLabel
     *
     * @return string 
     */
    public function getUniLabel()
    {
        return $this->uniLabel;
    }

    /**
     * Set uniShortLabel
     *
     * @param string $uniShortLabel
     * @return Unite
     */
    public function setUniShortLabel($uniShortLabel)
    {
        $this->uniShortLabel = $uniShortLabel;

        return $this;
    }

    /**
     * Get uniShortLabel
     *
     * @return string 
     */
    public function getUniShortLabel()
    {
        return $this->uniShortLabel;
    }

    /**
     * Set uniDescription
     *
     * @param string $uniDescription
     * @return Unite
     */
    public function setUniDescription($uniDescription)
    {
        $this->uniDescription = $uniDescription;

        return $this;
    }

    /**
     * Get uniDescription
     *
     * @return string 
     */
    public function getUniDescription()
    {
        return $this->uniDescription;
    }

    /**
     * Set uniValide
     *
     * @param boolean $uniValide
     * @return Unite
     */
    public function setUniValide($uniValide)
    {
        $this->uniValide = $uniValide;

        return $this;
    }

    /**
     * Get uniValide
     *
     * @return boolean 
     */
    public function getUniValide()
    {
        return $this->uniValide;
    }

    /**
     * Set utilisateur
     *
     * @param \PP\UserBundle\Entity\Utilisateur $utilisateur
     * @return Unite
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
