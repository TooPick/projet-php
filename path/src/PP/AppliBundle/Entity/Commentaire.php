<?php

namespace PP\AppliBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table(name="t_commentaire_com")
 * @ORM\Entity(repositoryClass="PP\AppliBundle\Entity\CommentaireRepository")
 */
class Commentaire
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
     * @ORM\Column(name="com_texte", type="text")
     */
    private $comTexte;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="com_date", type="datetime")
     */
    private $comDate;
	
	/** 
	 * @ORM\ManyToOne(targetEntity="PP\AppliBundle\Entity\Recette")
	 * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
	 */
	private $recette;
	
	/** 
	 * @ORM\ManyToOne(targetEntity="PP\UserBundle\Entity\Utilisateur")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $utilisateur;
	
	public function __construct()
	{
		$this->setComDate(new \DateTime());
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
     * Set comTexte
     *
     * @param string $comTexte
     * @return Commentaire
     */
    public function setComTexte($comTexte)
    {
        $this->comTexte = $comTexte;

        return $this;
    }

    /**
     * Get comTexte
     *
     * @return string 
     */
    public function getComTexte()
    {
        return $this->comTexte;
    }

    /**
     * Set comDate
     *
     * @param \DateTime $comDate
     * @return Commentaire
     */
    public function setComDate($comDate)
    {
        $this->comDate = $comDate;

        return $this;
    }

    /**
     * Get comDate
     *
     * @return \DateTime 
     */
    public function getComDate()
    {
        return $this->comDate;
    }

    /**
     * Set recette
     *
     * @param \PP\AppliBundle\Entity\Recette $recette
     * @return Commentaire
     */
    public function setRecette(\PP\AppliBundle\Entity\Recette $recette)
    {
        $this->recette = $recette;

        return $this;
    }

    /**
     * Get recette
     *
     * @return \PP\AppliBundle\Entity\Recette 
     */
    public function getRecette()
    {
        return $this->recette;
    }


    /**
     * Set utilisateur
     *
     * @param \PP\UserBundle\Entity\Utilisateur $utilisateur
     * @return Commentaire
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
