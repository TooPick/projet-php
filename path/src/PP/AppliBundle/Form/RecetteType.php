<?php

namespace PP\AppliBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use PP\AppliBundle\Entity\Categorie;
use PP\AppliBundle\Entity\Ingredient;

class RecetteType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rctTitre', 'text', array('label' => 'Titre :'))
            ->add('rctDescription', 'textarea', array('label' => 'Description :', 'attr' => array('rows' => 10)))
            ->add('rctTempsPreparation', 'time', array('label' => 'Temps de préparation :'))
            ->add('rctTempsCuisson', 'time', array('label' => 'Temps de cuisson :'))
            ->add('rctTempsRepos', 'time', array('label' => 'Temps de repos :'))
      			->add('rctDifficulte', 'choice', array(
      				'choices'   => array('facile' => 'Facile', 'moyen' => 'Moyen', 'difficile' => 'Difficile'),
      				'required'  => true,
      				'label'		=> 'Difficulté :'
      			))
      			->add('rctCout', 'choice', array(
      				'choices'   => array('faible' => 'Faible', 'moyen' => 'Moyen', 'eleve' => 'Elevé'),
      				'required'  => true,
      				'label'		=> 'Coût :'
      			))
      			->add('rctStatut', 'choice', array(
      				'choices'   => array('brouillon' => 'Brouillon', 'soumise' => 'Mettre en attente de relecture'),
      				'required'  => true,
      				'label'		=> 'Statut :'
      			))
            ->add('rctIllustration', 'text', array('label' => 'Illustration de la recette :'))
            ->add('rctNbpersonne', 'integer', array('label' => 'Nombre de personnes :'))
            ->add('categorie', 'entity', array(
              'class'    => 'PPAppliBundle:Categorie',
              'property' => 'catLabel',
              'label'		=> 'Catégorie de la recette :'
            ))
            ->add('ingredients', 'entity', array(
              'class'          => 'PPAppliBundle:Ingredient',
              'property'     => 'igdLabel',
              'multiple'  => true,
              'label'         => 'Gestion des ingrédients :',
              'required'  => false
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PP\AppliBundle\Entity\Recette'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pp_applibundle_recette';
    }
}
