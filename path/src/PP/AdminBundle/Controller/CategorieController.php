<?php

namespace PP\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PP\AppliBundle\Entity\Categorie;

use PP\AppliBundle\Form\CategorieType;

class CategorieController extends Controller
{	
	public function ajouterAction()
	{
		$categorie = new Categorie();
		$form = $this->createForm(new CategorieType, $categorie);

		$request = $this->getRequest();
		if($request->getMethod() == "POST")
		{
			$form->bind($request);
			if($form->isValid())
			{
				$em = $this->getDoctrine()->getManager();
				$em->persist($categorie);
				$em->flush();

				$url = $this->generateUrl('pp_admin_homepage');
				return $this->redirect($url);
			}
		}

		return $this->render('PPAdminBundle:Categorie:ajouter.html.twig', array('form' => $form->createView()));
	}
}
