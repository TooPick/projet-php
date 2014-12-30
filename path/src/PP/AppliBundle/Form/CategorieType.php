<?php

namespace PP\AppliBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use PP\AppliBundle\Form\ImageType;

class CategorieType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('catLabel', NULL, array('label' => "Nom :"))
            ->add('catDescription', NULL, array('label' => "Description :"))
            ->add('catIllustration', new ImageType(), array('label' => 'Illustration de la catégorie :'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PP\AppliBundle\Entity\Categorie'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pp_applibundle_categorie';
    }
}
