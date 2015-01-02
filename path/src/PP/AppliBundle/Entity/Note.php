<?php

namespace PP\AppliBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Note
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="PP\AppliBundle\Entity\NoteRepository")
 */
class Note
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
     * @var integer
     *
     * @ORM\Column(name="note", type="integer")
     */
    private $note;

    /** 
     * @ORM\ManyToOne(targetEntity="PP\UserBundle\Entity\Utilisateur", inversedBy="notes")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $utilisateur;

    /** 
     * @ORM\ManyToOne(targetEntity="PP\AppliBundle\Entity\Recette")
     * @ORM\JoinColumn(nullable=false)
     */
    private $recette;

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
     * Set note
     *
     * @param integer $note
     * @return Note
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return integer 
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set utilisateur
     *
     * @param \PP\UserBundle\Entity\Utilisateur $utilisateur
     * @return Note
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
     * Set recette
     *
     * @param \PP\AppliBundle\Entity\Recette $recette
     * @return Note
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
}
