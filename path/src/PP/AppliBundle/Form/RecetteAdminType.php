<?php

namespace PP\AppliBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use PP\AppliBundle\Entity\Categorie;

class RecetteAdminType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rctTitre')
            ->add('rctDescription')
            ->add('rctTempsPreparation')
            ->add('rctTempsCuisson')
            ->add('rctTempsRepos')
      			->add('rctDifficulte', 'choice', array(
      				'choices'   => array('facile' => 'Facile', 'moyen' => 'Moyen', 'difficile' => 'Difficile'),
      				'required'  => true,
      			))
      			->add('rctCout', 'choice', array(
      				'choices'   => array('faible' => 'Faible', 'moyen' => 'Moyen', 'eleve' => 'Elevé'),
      				'required'  => true,
      			))
      			->add('rctStatut', 'choice', array(
      				'choices'   => array('brouillon' => 'Brouillon', 'soumise' => 'Mettre en attente de relecture', 'finale' => 'Publier'),
      				'required'  => true,
      			))
            ->add('rctIllustration', new ImageType(), array('label' => 'Illustration de la recette :'))
            ->add('rctNbpersonne')
            ->add('categorie', 'entity', array(
              'class'    => 'PPAppliBundle:Categorie',
              'property' => 'catLabel'
            ))
			     ->add('valider', 'submit')
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
