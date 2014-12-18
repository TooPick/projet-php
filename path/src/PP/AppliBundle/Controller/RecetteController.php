<?php

namespace PP\AppliBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PP\AppliBundle\Entity\Recette;
use PP\AppliBundle\Entity\Ingredient;
use PP\AppliBundle\Entity\Unite;
use PP\AppliBundle\Entity\IngredientUnite;

use PP\AppliBundle\Form\RecetteType;
use PP\AppliBundle\Form\IngredientType;
use PP\AppliBundle\Form\UniteType;
use PP\AppliBundle\Form\IngredientUniteType;

class RecetteController extends Controller
{
    public function ajouterRecetteAction()
	{
		$recette = new Recette();
		$form = $this->createForm(new RecetteType, $recette);

		$ingredient = new Ingredient();
		$ingredientForm = $this->createForm(new IngredientType, $ingredient);

		$unite = new Unite();
		$uniteForm = $this->createForm(new UniteType, $unite);

		$ing_uni = new IngredientUnite();
		$ing_uniForm = $this->createForm(new IngredientUniteType, $ing_uni);
	
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
	
		return $this->render('PPAppliBundle:Recette:ajouterRecette.html.twig', array('form' => $form->createView(), 'ingredientForm' => $ingredientForm->createView(), 'uniteForm' => $uniteForm->createView(), 'ing_uniForm' => $ing_uniForm->createView(), 'recette' => $recette));
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
		
		return $this->render('PPAppliBundle:Recette:editerRecette.html.twig', array('form' => $form->createView(), 'ingredientForm' => $ingredientForm->createView(), 'uniteForm' => $uniteForm->createView(), 'ing_uniForm' => $ing_uniForm->createView(), 'recette' => $recette));
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