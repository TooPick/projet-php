<?php

namespace PP\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use PP\AppliBundle\Form\ImageType;

class EditUtilisateurType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('password')
            ->add('utiMail')
            ->add('utiNom')
            ->add('utiPrenom')
			->add('sauvegarder', 'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PP\UserBundle\Entity\Utilisateur'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pp_userbundle_utilisateur';
    }
}
