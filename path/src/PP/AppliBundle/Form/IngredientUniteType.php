<?php

namespace PP\AppliBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IngredientUniteType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ingredient', 'entity', array(
              'class'    => 'PPAppliBundle:Ingredient',
              'property' => 'igdLabel',
              'label'       => 'Ingrédient :'
            ))
            ->add('unite', 'entity', array(
              'class'    => 'PPAppliBundle:Unite',
              'property' => 'uniLabel',
              'label'       => 'Unité :'
            ))
            ->add('quantite', NULL, array('required' => false, 'label' => 'Quantite :', 'attr' => array('class' => 'form-control')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PP\AppliBundle\Entity\IngredientUnite'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pp_applibundle_ingredientunite';
    }
}
