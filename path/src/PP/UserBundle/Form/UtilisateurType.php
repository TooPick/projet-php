<?php

namespace PP\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UtilisateurType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text', array('label' => 'Nom d\'utilisateur :'))
            ->add('password', 'password', array('label' => 'Mot de passe :'))
            ->add('utiMail', 'email', array('label' => 'Email :'))
            ->add('utiNom', 'text', array('label' => 'Nom :'))
            ->add('utiPrenom', 'text', array('label' => 'Prénom :'))
			->add('inscription', 'submit')
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
