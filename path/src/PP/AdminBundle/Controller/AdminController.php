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
	
	public function recettesAttenteAction()
	{
		$em = $this->getDoctrine()->getManager();
		$recetteRepository = $em->getRepository('PPAppliBundle:Recette');
		
		$recettes = $recetteRepository->findBy(array('rctStatut' => 'soumise'));
		
		return $this->render('PPAdminBundle:Admin:recettesAttente.html.twig', array('recettes' => $recettes));
	}
	
	public function editerRecetteAction($id)
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
				
				$url = $this->generateUrl('pp_admin_recettesAttente');
				return $this->redirect($url);
			}
		}
		
		return $this->render('PPAdminBundle:Admin:editerRecette.html.twig', array('form' => $form->createView()));
	}
	
	public function listeUtilisateursAction($utilisateur)
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
	
	
		return $this->render('PPAdminBundle:Admin:listeUtilisateurs.html.twig', array('utilisateurs' => $utilisateurs));
	}
	
	public function editerUtilisateurAction($id)
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
				
				$url = $this->generateUrl('pp_admin_listeUtilisateurs');
				return $this->redirect($url);
			}
		}
		
		return $this->render('PPAdminBundle:Admin:editerUtilisateur.html.twig', array('form' => $form->createView()));
	}
	
	public function listeRecettesUtilisateurAction($id)
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
		
		return $this->render('PPAdminBundle:Admin:listeRecettesUtilisateur.html.twig', array('recettes' => $recettes, 'user' => $user));
	}
	
	public function listeRecettesAction($recette)
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
		
		return $this->render('PPAdminBundle:Admin:listeRecettes.html.twig', array('recettes' => $recettes));
	}

	public function ingredientsAttenteAction()
	{
		$em = $this->getDoctrine()->getManager();
		$ingredientRepository = $em->getRepository('PPAppliBundle:Ingredient');

		$ingredients = $ingredientRepository->findBy(array('igdValide' => 0));

		return $this->render('PPAdminBundle:Admin:ingredientsAttente.html.twig', array('ingredients' => $ingredients));
	}
}
