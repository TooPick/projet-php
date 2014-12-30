<?php

namespace PP\AppliBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use PP\UserBundle\Entity\Utilisateur;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Image
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="PP\AppliBundle\Entity\ImageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Image
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
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255, nullable=true)
     */
    private $alt;

    private $file;

    /** 
     * @ORM\ManyToOne(targetEntity="PP\UserBundle\Entity\Utilisateur")
     * @ORM\JoinColumn(nullable=true)
     */
    private $utilisateur;

    /**
     * @var string
     *
     * @ORM\Column(name="nameTemp", type="string", length=255, nullable=true)
     */
    private $nameTemp;

    public function __construct()
    {
        $this->setUtilisateur(NULL);
    }

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

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
     * Set url
     *
     * @param string $url
     * @return Image
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set alt
     *
     * @param string $alt
     * @return Image
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string 
     */
    public function getAlt()
    {
        return $this->alt;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile(UploadedFile $file = NULL)
    {
        $ext = $file->guessExtension();
        if($ext == "png" || $ext == "jpeg" || $ext == "gif" )
        {
            $this->setNameTemp($this->getUrl());
            $this->file = $file;

            $this->setUrl(NULL);
            $this->setAlt(NULL);
        }
    }

    /**
     * Set utilisateur
     *
     * @param \PP\UserBundle\Entity\Utilisateur $utilisateur
     * @return Image
     */
    public function setUtilisateur(\PP\UserBundle\Entity\Utilisateur $utilisateur = null)
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
     * Set type
     *
     * @param string $type
     * @return Image
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if($this->file == NULL)
            return;

        $this->setUrl($this->getFile()->guessExtension());
        $this->setAlt($this->getFile()->getClientOriginalName());
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if($this->getFile() == NULL || $this->getType() == NULL)
            return;

        if($this->getUtilisateur() == NULL)
            $path = $this->getUploadRootDir();
        else
            $path = $this->getUploadRootDir().'/'.$this->getUtilisateur()->getUsername();

        switch ($this->getType()) {
            case 'avatar':
                $this->setAlt('avatar.');
                break;

            case 'recette':
                $this->setAlt($this->getId().'.');
                $path = $path.'/recettes';
                break;

            case 'ingredient':
                $this->setAlt($this->getId().'.');
                $path = $path.'/ingredients';
                break;

            case 'categorie':
                $this->setAlt($this->getId().'.');
                $path = $path.'/categories';
                break;
            
            default:
                return;
                break;
        }

        $name = $path.'/'.$this->getAlt().$this->getNameTemp();
        if (file_exists($name) && is_writable($name))
        {
            unlink ($name);
        }

        $this->file->move($path, $this->getAlt().$this->getUrl());

    }

    public function getUploadDir()
    {
        return 'uploads/images';
    }

    public function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    /**
     * Set nameTemp
     *
     * @param string $nameTemp
     * @return Image
     */
    public function setNameTemp($nameTemp)
    {
        $this->nameTemp = $nameTemp;

        return $this;
    }

    /**
     * Get nameTemp
     *
     * @return string 
     */
    public function getNameTemp()
    {
        return $this->nameTemp;
    }
}
