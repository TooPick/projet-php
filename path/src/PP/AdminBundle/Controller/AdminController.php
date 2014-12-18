<?php

namespace PP\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PP\AppliBundle\Entity\Recette;
use PP\UserBundle\Entity\Utilisateur;

use PP\AppliBundle\Form\RecetteAdminType;
use PP\UserBundle\Form\EditUtilisateurType;

class AdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('PPAdminBundle:Admin:index.html.twig');
    }

}
