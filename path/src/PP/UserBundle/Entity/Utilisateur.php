<?php

namespace PP\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use PP\AppliBundle\Entity\Image;

/**
 * Utilisateur
 *
 * @ORM\Table(name="t_utilisateur_uti")
 * @ORM\Entity(repositoryClass="PP\UserBundle\Entity\UtilisateurRepository")
 * @UniqueEntity("username")
 * @UniqueEntity("utiMail")
 */
class Utilisateur implements UserInterface
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
	 * @ORM\Column(name="username", type="string", length=255, unique=true)
	 */
	private $username;
	
	/**
	 * @ORM\Column(name="password", type="string", length=255)
	 */
	private $password;
	
	/**
	 * @ORM\Column(name="salt", type="string", length=255)
	 */
	private $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="uti_mail", type="string", length=255)
     */
    private $utiMail;

    /**
     * @var string
     *
     * @ORM\Column(name="uti_nom", type="string", length=255)
     */
    private $utiNom;

    /**
     * @var string
     *
     * @ORM\Column(name="uti_prenom", type="string", length=255)
     */
    private $utiPrenom;
	
	/**
	 * @ORM\Column(name="roles", type="array")
	 */ 
	private $roles;

    /**
     * @ORM\OneToMany(targetEntity="PP\AppliBundle\Entity\Commentaire", mappedBy="utilisateur")
     */
    protected $commentaires;

    /**
     * @ORM\OneToMany(targetEntity="PP\AppliBundle\Entity\Note", mappedBy="utilisateur")
     */
    protected $notes;

    /**
     * @ORM\OneToMany(targetEntity="PP\AppliBundle\Entity\Image", mappedBy="utilisateur")
     */
    protected $images;

    /**
     * @ORM\OneToMany(targetEntity="PP\AppliBundle\Entity\Recette", mappedBy="utilisateur")
     */
    protected $recettes;

	public function __construct()
	{
		$this->roles = array('ROLE_USER');
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
     * Set username
     *
     * @param string $username
     * @return Utilisateur
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Utilisateur
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return Utilisateur
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set utiMail
     *
     * @param string $utiMail
     * @return Utilisateur
     */
    public function setUtiMail($utiMail)
    {
        $this->utiMail = $utiMail;

        return $this;
    }

    /**
     * Get utiMail
     *
     * @return string 
     */
    public function getUtiMail()
    {
        return $this->utiMail;
    }

    /**
     * Set utiNom
     *
     * @param string $utiNom
     * @return Utilisateur
     */
    public function setUtiNom($utiNom)
    {
        $this->utiNom = $utiNom;

        return $this;
    }

    /**
     * Get utiNom
     *
     * @return string 
     */
    public function getUtiNom()
    {
        return $this->utiNom;
    }

    /**
     * Set utiPrenom
     *
     * @param string $utiPrenom
     * @return Utilisateur
     */
    public function setUtiPrenom($utiPrenom)
    {
        $this->utiPrenom = $utiPrenom;

        return $this;
    }

    /**
     * Get utiPrenom
     *
     * @return string 
     */
    public function getUtiPrenom()
    {
        return $this->utiPrenom;
    }

    /**
     * Set roles
     *
     * @param array $roles
     * @return Utilisateur
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return array 
     */
    public function getRoles()
    {
        return $this->roles;
    }
	
	public function eraseCredentials()
	{
    }

    /**
     * Add commentaires
     *
     * @param \PP\AppliBundle\Entity\Commentaire $commentaires
     * @return Utilisateur
     */
    public function addCommentaire(\PP\AppliBundle\Entity\Commentaire $commentaires)
    {
        $this->commentaires[] = $commentaires;

        return $this;
    }

    /**
     * Remove commentaires
     *
     * @param \PP\AppliBundle\Entity\Commentaire $commentaires
     */
    public function removeCommentaire(\PP\AppliBundle\Entity\Commentaire $commentaires)
    {
        $this->commentaires->removeElement($commentaires);
    }

    /**
     * Get commentaires
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }

    /**
     * Add notes
     *
     * @param \PP\AppliBundle\Entity\Note $notes
     * @return Utilisateur
     */
    public function addNote(\PP\AppliBundle\Entity\Note $notes)
    {
        $this->notes[] = $notes;

        return $this;
    }

    /**
     * Remove notes
     *
     * @param \PP\AppliBundle\Entity\Note $notes
     */
    public function removeNote(\PP\AppliBundle\Entity\Note $notes)
    {
        $this->notes->removeElement($notes);
    }

    /**
     * Get notes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Add images
     *
     * @param \PP\AppliBundle\Entity\Image $images
     * @return Utilisateur
     */
    public function addImage(\PP\AppliBundle\Entity\Image $images)
    {
        $this->images[] = $images;

        return $this;
    }

    /**
     * Remove images
     *
     * @param \PP\AppliBundle\Entity\Image $images
     */
    public function removeImage(\PP\AppliBundle\Entity\Image $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Add recettes
     *
     * @param \PP\AppliBundle\Entity\Recette $recettes
     * @return Utilisateur
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
