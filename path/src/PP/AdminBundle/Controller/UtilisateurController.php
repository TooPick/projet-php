<?php

namespace PP\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PP\AppliBundle\Entity\Recette;
use PP\UserBundle\Entity\Utilisateur;

use PP\UserBundle\Form\EditUtilisateurType;

class UtilisateurController extends Controller
{	
	public function listeAction($utilisateur)
	{
		$request = $this->getRequest();
		if($request->getMethod() == "POST")
		{
			extract($_POST);
			if($searchUser != NULL)
				$url = $this->generateUrl('pp_admin_listeUtilisateurs', array('utilisateur' => $searchUser));
			else
				$url = $this->generateUrl('pp_admin_listeUtilisateurs');

			return $this->redirect($url);
		}

		$em = $this->getDoctrine()->getManager();
		$userRepository = $em->getRepository('PPUserBundle:Utilisateur');

		if($utilisateur != NULL)
			$utilisateurs = $userRepository->searchUser($utilisateur);
		else
			$utilisateurs = $userRepository->findAll();
	
	
		return $this->render('PPAdminBundle:Utilisateur:liste.html.twig', array('utilisateurs' => $utilisateurs));
	}
	
	public function editAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		$userRepository = $em->getRepository('PPUserBundle:Utilisateur');
		
		$user = $userRepository->find($id);
		
		if($user == NULL)
		{
			$url = $this->generateUrl('pp_admin_listeUtilisateurs');
			return $this->redirect($url);
		}
		
		$form = $this->createForm(new EditUtilisateurType, $user);
		
		$request = $this->getRequest();
		if($request->getMethod() == "POST")
		{
			$form->bind($request);
			
			if($form->isValid())
			{
				$em->persist($user);
				$em->flush();

				$this->get('session')->getFlashBag()->add(
		            'alert-success',
		            'L\'utilisateur a bien été modifié !'
		        );
				
				$url = $this->generateUrl('pp_admin_listeUtilisateurs');
				return $this->redirect($url);
			}
		}
		
		return $this->render('PPAdminBundle:Utilisateur:edit.html.twig', array('form' => $form->createView()));
	}
	
	public function recettesUtilisateurAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		$recetteRepository = $em->getRepository('PPAppliBundle:Recette');
		$userRepository = $em->getRepository('PPUserBundle:Utilisateur');
		
		$user = $userRepository->find($id);
		
		if($user == NULL)
		{
			$url = $this->generateUrl('pp_admin_listeUtilisateurs');
			return $this->redirect($url);
		}
	
		$recettes = $recetteRepository->findBy(array('utilisateur' => $user));
		
		return $this->render('PPAdminBundle:Utilisateur:recettesUtilisateur.html.twig', array('recettes' => $recettes, 'user' => $user));
	}

}
