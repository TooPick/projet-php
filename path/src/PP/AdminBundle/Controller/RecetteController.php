<?php

namespace PP\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PP\AppliBundle\Entity\Recette;

use PP\AppliBundle\Form\RecetteAdminType;

class RecetteController extends Controller
{	
	public function attenteAction()
	{
		$em = $this->getDoctrine()->getManager();
		$recetteRepository = $em->getRepository('PPAppliBundle:Recette');
		
		$recettes = $recetteRepository->findBy(array('rctStatut' => 'soumise'));
		
		return $this->render('PPAdminBundle:Recette:attente.html.twig', array('recettes' => $recettes));
	}

	public function brouillonAction()
	{
		$em = $this->getDoctrine()->getManager();
		$recetteRepository = $em->getRepository('PPAppliBundle:Recette');
		
		$recettes = $recetteRepository->findBy(array('rctStatut' => 'brouillon'));
		
		return $this->render('PPAdminBundle:Recette:brouillon.html.twig', array('recettes' => $recettes));
	}
	
	public function editAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		$recetteRepository = $em->getRepository('PPAppliBundle:Recette');
		
		$recette = $recetteRepository->find($id);
		
		if($recette == NULL)
		{
			$url = $this->generateUrl('pp_admin_recettesAttente');
			return $this->redirect($url);
		}
		
		$form = $this->createForm(new RecetteAdminType, $recette);
		
		$request = $this->getRequest();
		if($request->getMethod() == "POST")
		{
			$form->bind($request);
			
			if($form->isValid())
			{
				$recette->setRctDate(new \DateTime());
				$em->persist($recette);
				$em->flush();

				$this->get('session')->getFlashBag()->add(
		            'alert-success',
		            'La recette a bien été modifiée !'
		        );
				
				$url = $this->generateUrl('pp_admin_recettesAttente');
				return $this->redirect($url);
			}
		}
		
		return $this->render('PPAdminBundle:Recette:edit.html.twig', array('form' => $form->createView(), 'recette' => $recette));
	}
	
	public function listeAction($recette)
	{
		$request = $this->getRequest();
		if($request->getMethod() == "POST")
		{
			extract($_POST);
			if($searchRecette != NULL)
				$url = $this->generateUrl('pp_admin_listeRecettes', array('recette' => $searchRecette));
			else
				$url = $this->generateUrl('pp_admin_listeRecettes');

			return $this->redirect($url);
		}

		$em = $this->getDoctrine()->getManager();
		$recetteRepository = $em->getRepository('PPAppliBundle:Recette');

		if($recette != NULL)
			$recettes = $recetteRepository->searchRecette($recette);
		else
			$recettes = $recetteRepository->findAll();
		
		return $this->render('PPAdminBundle:Recette:liste.html.twig', array('recettes' => $recettes));
	}

}
