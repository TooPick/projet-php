<?php

namespace PP\AppliBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PP\AppliBundle\Entity\Recette;
use PP\AppliBundle\Entity\Ingredient;
use PP\AppliBundle\Entity\Unite;
use PP\AppliBundle\Entity\IngredientUnite;
use PP\AppliBundle\Entity\Image;

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
				$recette->getRctIllustration()->setType('recette');
				$recette->getRctIllustration()->setUtilisateur($this->getUser());
				$em->persist($recette);
				$em->flush();

				$this->get('session')->getFlashBag()->add(
                    'alert-success',
                    'La recette a bien été sauvegardée !'
                );
				
				$url = $this->generateUrl('pp_appli_editRecette', array('id' => $recette->getId()));
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
			if($form->isValid())
			{
				$em = $this->getDoctrine()->getManager();
				$recette->getRctIllustration()->setType('recette');
				$recette->getRctIllustration()->setUtilisateur($this->getUser());
				$em->persist($recette);
				$em->flush();

				$this->get('session')->getFlashBag()->add(
                    'alert-success',
                    'La recette a bien été sauvegardée !'
                );
				
				$url = $this->generateUrl('pp_appli_editRecette', array('id' => $recette->getId()));
				return $this->redirect($url);
			}
		}
		
		return $this->render('PPAppliBundle:Recette:editerRecette.html.twig', array('form' => $form->createView(), 'ingredientForm' => $ingredientForm->createView(), 'uniteForm' => $uniteForm->createView(), 'recette' => $recette));
	}

	public function supprimerRecetteAction(Recette $recette = NULL)
	{		
		if($recette != NULL && $recette->getUtilisateur() == $this->getUser())
		{
			$em = $this->getDoctrine()->getManager();
			$em->remove($recette);
			$em->flush();

			$this->get('session')->getFlashBag()->add(
                'alert-success',
                'La recette a bien été supprimée !'
            );
		}
	
		$url = $this->generateUrl('pp_user_profil');
		return $this->redirect($url);
	}

	public function ajouterUniteAction()
	{
		$unite = new Unite();
		$uniteForm = $this->createForm(new UniteType, $unite);

		$request = $this->getRequest();
		if($request->getMethod() == "POST")
		{
			$uniteForm->bind($request);
			if($uniteForm->isValid())
			{
				$em = $this->getDoctrine()->getManager();
				$unite->setUtilisateur($this->getUser());
				$em->persist($unite);
				$em->flush();

				$this->get('session')->getFlashBag()->add(
                    'alert-success',
                    'L\'unité a bien été ajoutée !'
                );

				$url = $this->generateUrl('pp_user_profil');
				return $this->redirect($url);
			}
		}
	}

	public function ajouterIngredientRecetteAction()
	{
		$ing_uni = new IngredientUnite();
		$ing_uniForm = $this->createForm(new IngredientUniteType, $ing_uni);

		$request = $this->getRequest();
		if($request->getMethod() == "POST")
		{
			$ing_uniForm->bind($request);
			if($ing_uniForm->isValid())
			{
				$em = $this->getDoctrine()->getManager();
				$em->persist($ing_uni);
				$em->flush();

				$this->get('session')->getFlashBag()->add(
                    'alert-success',
                    'L\'ingrédient a bien été ajouté à la recette !'
                );

				$url = $this->generateUrl('pp_user_profil');
				return $this->redirect($url);
			}
		}
	}
}
