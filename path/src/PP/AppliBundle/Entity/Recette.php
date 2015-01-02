<?php

namespace PP\AppliBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use PP\AppliBundle\Entity\Categorie;

/**
 * Recette
 *
 * @ORM\Table(name="t_recette_rct")
 * @ORM\Entity(repositoryClass="PP\AppliBundle\Entity\RecetteRepository")
 */
class Recette
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
     * @var \DateTime
     *
     * @ORM\Column(name="rct_date", type="datetime")
     */
    private $rctDate;

    /**
     * @var string
     *
     * @ORM\Column(name="rct_titre", type="string", length=80, nullable=true)
     */
    private $rctTitre;

    /**
     * @var string
     *
     * @ORM\Column(name="rct_description", type="text", nullable=true)
     */
    private $rctDescription;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="rct_temps_preparation", type="time", nullable=true)
     */
    private $rctTempsPreparation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="rct_temps_cuisson", type="time", nullable=true)
     */
    private $rctTempsCuisson;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="rct_temps_repos", type="time", nullable=true)
     */
    private $rctTempsRepos;

    /**
     * @var string
     *
     * @ORM\Column(name="rct_difficulte", type="string", length=255, nullable=true)
     */
    private $rctDifficulte;

    /**
     * @var string
     *
     * @ORM\Column(name="rct_cout", type="string", length=255, nullable=true)
     */
    private $rctCout;

    /**
     * @var string
     *
     * @ORM\Column(name="rct_statut", type="string", length=255, nullable=true)
     */
    private $rctStatut;

    /**
     * @ORM\OneToOne(targetEntity="PP\AppliBundle\Entity\Image", cascade={"persist"})
     */
    private $rctIllustration;

    /**
     * @var integer
     *
     * @ORM\Column(name="rct_nbpersonne", type="integer", nullable=true)
     */
    private $rctNbpersonne;
	
	/** 
	 * @ORM\ManyToOne(targetEntity="PP\AppliBundle\Entity\Categorie")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $categorie;
	
	/** 
	 * @ORM\ManyToOne(targetEntity="PP\UserBundle\Entity\Utilisateur", inversedBy="recettes")
	 * @ORM\JoinColumn(nullable=false, onDelete="cascade")
	 */
	private $utilisateur;

    /** 
     * @ORM\ManyToMany(targetEntity="PP\AppliBundle\Entity\IngredientUnite", cascade="persist")
     */
    private $ingredients;
	
	public function __construct()
	{
		$this->setRctDate(new \DateTime());
		$this->setRctStatut('brouillon');
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
     * Set rctDate
     *
     * @param \DateTime $rctDate
     * @return Recette
     */
    public function setRctDate($rctDate)
    {
        $this->rctDate = $rctDate;

        return $this;
    }

    /**
     * Get rctDate
     *
     * @return \DateTime 
     */
    public function getRctDate()
    {
        return $this->rctDate;
    }

    /**
     * Set rctTitre
     *
     * @param string $rctTitre
     * @return Recette
     */
    public function setRctTitre($rctTitre)
    {
        $this->rctTitre = $rctTitre;

        return $this;
    }

    /**
     * Get rctTitre
     *
     * @return string 
     */
    public function getRctTitre()
    {
        return $this->rctTitre;
    }

    /**
     * Set rctDescription
     *
     * @param string $rctDescription
     * @return Recette
     */
    public function setRctDescription($rctDescription)
    {
        $this->rctDescription = $rctDescription;

        return $this;
    }

    /**
     * Get rctDescription
     *
     * @return string 
     */
    public function getRctDescription()
    {
        return $this->rctDescription;
    }

    /**
     * Set rctTempsPreparation
     *
     * @param \DateTime $rctTempsPreparation
     * @return Recette
     */
    public function setRctTempsPreparation($rctTempsPreparation)
    {
        $this->rctTempsPreparation = $rctTempsPreparation;

        return $this;
    }

    /**
     * Get rctTempsPreparation
     *
     * @return \DateTime 
     */
    public function getRctTempsPreparation()
    {
        return $this->rctTempsPreparation;
    }

    /**
     * Set rctTempsCuisson
     *
     * @param \DateTime $rctTempsCuisson
     * @return Recette
     */
    public function setRctTempsCuisson($rctTempsCuisson)
    {
        $this->rctTempsCuisson = $rctTempsCuisson;

        return $this;
    }

    /**
     * Get rctTempsCuisson
     *
     * @return \DateTime 
     */
    public function getRctTempsCuisson()
    {
        return $this->rctTempsCuisson;
    }

    /**
     * Set rctTempsRepos
     *
     * @param \DateTime $rctTempsRepos
     * @return Recette
     */
    public function setRctTempsRepos($rctTempsRepos)
    {
        $this->rctTempsRepos = $rctTempsRepos;

        return $this;
    }

    /**
     * Get rctTempsRepos
     *
     * @return \DateTime 
     */
    public function getRctTempsRepos()
    {
        return $this->rctTempsRepos;
    }

    /**
     * Set rctDifficulte
     *
     * @param string $rctDifficulte
     * @return Recette
     */
    public function setRctDifficulte($rctDifficulte)
    {
        $this->rctDifficulte = $rctDifficulte;

        return $this;
    }

    /**
     * Get rctDifficulte
     *
     * @return string 
     */
    public function getRctDifficulte()
    {
        return $this->rctDifficulte;
    }

    /**
     * Set rctCout
     *
     * @param string $rctCout
     * @return Recette
     */
    public function setRctCout($rctCout)
    {
        $this->rctCout = $rctCout;

        return $this;
    }

    /**
     * Get rctCout
     *
     * @return string 
     */
    public function getRctCout()
    {
        return $this->rctCout;
    }

    /**
     * Set rctStatut
     *
     * @param string $rctStatut
     * @return Recette
     */
    public function setRctStatut($rctStatut)
    {
        $this->rctStatut = $rctStatut;

        return $this;
    }

    /**
     * Get rctStatut
     *
     * @return string 
     */
    public function getRctStatut()
    {
        return $this->rctStatut;
    }

    /**
     * Set rctNbpersonne
     *
     * @param integer $rctNbpersonne
     * @return Recette
     */
    public function setRctNbpersonne($rctNbpersonne)
    {
        $this->rctNbpersonne = $rctNbpersonne;

        return $this;
    }

    /**
     * Get rctNbpersonne
     *
     * @return integer 
     */
    public function getRctNbpersonne()
    {
        return $this->rctNbpersonne;
    }


    /**
     * Set categorie
     *
     * @param \PP\AppliBundle\Entity\Categorie $categorie
     * @return Recette
     */
    public function setCategorie(\PP\AppliBundle\Entity\Categorie $categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \PP\AppliBundle\Entity\Categorie 
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set utilisateur
     *
     * @param \PP\UserBundle\Entity\Utilisateur $utilisateur
     * @return Recette
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
     * Add ingredients
     *
     * @param \PP\AppliBundle\Entity\IngredientUnite $ingredients
     * @return Recette
     */
    public function addIngredient(\PP\AppliBundle\Entity\IngredientUnite $ingredients)
    {
        $this->ingredients[] = $ingredients;

        return $this;
    }

    /**
     * Remove ingredients
     *
     * @param \PP\AppliBundle\Entity\IngredientUnite $ingredients
     */
    public function removeIngredient(\PP\AppliBundle\Entity\IngredientUnite $ingredients)
    {
        $this->ingredients->removeElement($ingredients);
    }

    /**
     * Get ingredients
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }

    /**
     * Set rctIllustration
     *
     * @param \PP\AppliBundle\Entity\Image $rctIllustration
     * @return Recette
     */
    public function setRctIllustration(\PP\AppliBundle\Entity\Image $rctIllustration = null)
    {
        $this->rctIllustration = $rctIllustration;

        return $this;
    }

    /**
     * Get rctIllustration
     *
     * @return \PP\AppliBundle\Entity\Image 
     */
    public function getRctIllustration()
    {
        return $this->rctIllustration;
    }
}
