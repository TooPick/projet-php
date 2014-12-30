<?php

namespace PP\AppliBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IngredientAdminType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('igdLabel', NULL, array('label' => 'Nom :', 'attr' => array('class' => 'form-control')))
            ->add('igdDescription', NULL, array('label' => 'Description :', 'attr' => array('class' => 'form-control')))
            ->add('igdIllustration', new ImageType(), array('label' => 'Illustration de l\'ingrédient :', 'attr' => array('class' => 'form-control')))
            ->add('igdValide', 'choice', array(
                    'choices'   => array(1 => 'Validé', 0 => 'En Attente'),
                    'required'  => true,
                    'label'     => 'Statut :'
                ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PP\AppliBundle\Entity\Ingredient'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pp_applibundle_ingredient';
    }
}
