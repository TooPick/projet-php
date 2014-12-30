<?php

namespace PP\AppliBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categorie
 *
 * @ORM\Table(name="t_categorie_cat")
 * @ORM\Entity(repositoryClass="PP\AppliBundle\Entity\CategorieRepository")
 */
class Categorie
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
     * @ORM\Column(name="cat_label", type="string", length=255)
     */
    private $catLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="cat_description", type="text")
     */
    private $catDescription;

    /**
     * @ORM\OneToOne(targetEntity="PP\AppliBundle\Entity\Image", cascade={"persist"})
     */
    private $catIllustration;


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
     * Set catLabel
     *
     * @param string $catLabel
     * @return Categorie
     */
    public function setCatLabel($catLabel)
    {
        $this->catLabel = $catLabel;

        return $this;
    }

    /**
     * Get catLabel
     *
     * @return string 
     */
    public function getCatLabel()
    {
        return $this->catLabel;
    }

    /**
     * Set catDescription
     *
     * @param string $catDescription
     * @return Categorie
     */
    public function setCatDescription($catDescription)
    {
        $this->catDescription = $catDescription;

        return $this;
    }

    /**
     * Get catDescription
     *
     * @return string 
     */
    public function getCatDescription()
    {
        return $this->catDescription;
    }

    /**
     * Set catIllustration
     *
     * @param \PP\AppliBundle\Entity\Image $catIllustration
     * @return Categorie
     */
    public function setCatIllustration(\PP\AppliBundle\Entity\Image $catIllustration = null)
    {
        $this->catIllustration = $catIllustration;

        return $this;
    }

    /**
     * Get catIllustration
     *
     * @return \PP\AppliBundle\Entity\Image 
     */
    public function getCatIllustration()
    {
        return $this->catIllustration;
    }
}
