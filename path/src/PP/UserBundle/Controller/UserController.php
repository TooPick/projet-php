<?php

namespace PP\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Security\Core\SecurityContext;

use PP\UserBundle\Entity\Utilisateur;
use PP\AppliBundle\Entity\Recette;
use PP\AppliBundle\Entity\Ingredient;
use PP\AppliBundle\Entity\Unite;
use PP\AppliBundle\Entity\IngredientUnite;

use PP\UserBundle\Form\UtilisateurType;
use PP\UserBundle\Form\EditUtilisateurType;
use PP\AppliBundle\Form\RecetteType;
use PP\AppliBundle\Form\IngredientType;
use PP\AppliBundle\Form\UniteType;
use PP\AppliBundle\Form\IngredientUniteType;

class UserController extends Controller
{
	public function profilAction()
	{
		$em = $this->getDoctrine()->getManager();
		$recetteRepository = $em->getRepository('PPAppliBundle:Recette');
		
		$utilisateur = $this->getUser();
		
		$recettes = $recetteRepository->findBy(array('utilisateur' => $utilisateur));
		
		return $this->render('PPUserBundle:Pages:profil.html.twig', array('recettes' => $recettes, 'utilisateur' => $utilisateur));
	}

    public function inscriptionAction()
    {
		$utilisateur = new Utilisateur();
		$form = $this->createForm(new UtilisateurType, $utilisateur);
		
		$request = $this->get('request');
		if($request->getMethod() == "POST")
		{
			$form->bind($request);
			
			if($form->isValid())
			{
				$em = $this->getDoctrine()->getManager();
				
				$utilisateur->setSalt('');
				$utilisateur->setUtiAvatar('');
				//$utilisateur->setRoles(array("ROLE_ADMIN"));
				$em->persist($utilisateur);
				$em->flush();
				
				$url = $this->generateUrl('pp_appli_index');
				return $this->redirect($url);				
			}
		}
		
        return $this->render('PPUserBundle:Pages:inscription.html.twig', array('form' => $form->createView()));
    }
	
	public function loginAction()
	{
		if($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED'))
		{
			$url = $this->generateUrl('pp_appli_index');
			return $this->redirect($url);
		}
		
		$request = $this->getRequest();
		$session = $request->getSession();
		
		if($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR))
		{
			$error = $request->attributes->has(SecurityContext::AUTHENTICATION_ERROR);
		}
		else
		{
			$error = $request->attributes->has(SecurityContext::AUTHENTICATION_ERROR);
			$session->remove(SecurityContext::AUTHENTICATION_ERROR);
		}
		
		return $this->render('PPUserBundle:Pages:connexion.html.twig', array('last_username' => $session->get(SecurityContext::LAST_USERNAME), 'error' => $error));
	}
	
	public function editerProfilAction()
	{
		$user = $this->getUser();
		$form = $this->createForm(new EditUtilisateurType, $user);
		
		$request = $this->getRequest();
		if($request->getMethod() == "POST")
		{
			$form->bind($request);
			
			if($form->isValid())
			{
				$em = $this->getDoctrine()->getManager();
				$em->persist($user);
				$em->flush();
				
				$url = $this->generateUrl('pp_user_profil');
				return $this->redirect($url);
			}		
		}
	
		return $this->render('PPUserBundle:Pages:editerProfil.html.twig', array('form' => $form->createView()));
	}

	public function ajouterRecetteAction()
	{
		$recette = new Recette();
		$form = $this->createForm(new RecetteType, $recette);

		$ingredient = new Ingredient();
		$ingredientForm = $this->createForm(new IngredientType, $ingredient);
	
		$request = $this->get('request');
		if($request->getMethod() == "POST")
		{
			$form->bind($request);
			
			if($form->isValid())
			{
				$em = $this->getDoctrine()->getManager();
				
				$recette->setUtilisateur($this->getUser());
				$em->persist($recette);
				$em->flush();
				
				$url = $this->generateUrl('pp_user_profil');
				return $this->redirect($url);
			}
		}
	
		return $this->render('PPUserBundle:Pages:ajouterRecette.html.twig', array('form' => $form->createView(), 'ingredientForm' => $ingredientForm->createView()));
	}

	public function editRecetteAction(Recette $recette = NULL)
	{
		$form = $this->createForm(new RecetteType, $recette);

		$ingredient = new Ingredient();
		$ingredientForm = $this->createForm(new IngredientType, $ingredient);

		$unite = new Unite();
		$uniteForm = $this->createForm(new UniteType, $unite);

		$ing_uni = new IngredientUnite();
		$ing_uniForm = $this->createForm(new IngredientUniteType, $ing_uni);
		
		$user = $this->getUser();
		
		if($recette == NULL || $user != $recette->getUtilisateur())
		{
			$url = $this->generateUrl('pp_appli_index');
			return $this->redirect($url);
		}
		
		$request = $this->getRequest();
		if($request->getMethod() == "POST")
		{
			$form->bind($request);

			$em = $this->getDoctrine()->getManager();

			$ingredientForm->bind($request);
			if($ingredientForm->isValid())
			{
				$ingredient->setUtilisateur($this->getUser());
				$em->persist($ingredient);
				$em->flush();
			}
			else if($form->isValid())
			{
				$em->persist($recette);
				$em->flush();
				
				$url = $this->generateUrl('pp_user_profil');
				return $this->redirect($url);
			}
		}
		
		return $this->render('PPUserBundle:Pages:editerRecette.html.twig', array('form' => $form->createView(), 'ingredientForm' => $ingredientForm->createView(), 'uniteForm' => $uniteForm->createView(), 'ing_uniForm' => $ing_uniForm->createView(), 'recette' => $recette));
	}

	public function supprimerRecetteAction(Recette $recette = NULL)
	{		
		if($recette != NULL && $recette->getUtilisateur() == $this->getUser())
		{
			$em = $this->getDoctrine()->getManager();
			$em->remove($recette);
			$em->flush();
		}
	
		$url = $this->generateUrl('pp_user_profil');
		return $this->redirect($url);
	}

}
