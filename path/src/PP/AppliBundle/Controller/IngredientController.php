<?php

namespace PP\AppliBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PP\AppliBundle\Entity\Ingredient;
use PP\AppliBundle\Entity\Recette;

use PP\AppliBundle\Form\IngredientType;

class IngredientController extends Controller
{
    public function listeAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('PPAppliBundle:Ingredient');

    	$ingredients = $repository->findBy(array('utilisateur' => $this->getUser(), 'igdValide' => 0));

    	return $this->render('PPAppliBundle:Ingredient:liste.html.twig', array('ingredients' => $ingredients));
    }

    public function ajouterAction()
    {
    	$ingredient = new Ingredient();
    	$form = $this->createForm(new IngredientType, $ingredient);

    	$request = $this->getRequest();
    	if($request->getMethod() == "POST")
    	{
    		$form->bind($request);
    		if($form->isValid())
    		{
    			$em = $this->getDoctrine()->getManager();
    			$ingredient->setUtilisateur($this->getUser());
    			$ingredient->getIgdIllustration()->setType('ingredient');
    			$ingredient->getIgdIllustration()->setUtilisateur($this->getUser());
    			$em->persist($ingredient);
    			$em->flush();

    			$url = $this->generateUrl('pp_appli_listeIngredient');
    			return $this->redirect($url);
    		}
    	}

    	return $this->render('PPAppliBundle:Ingredient:ajouter.html.twig', array('form' => $form->createView()));
    }

    public function editionAction(Ingredient $ingredient = NULL)
    {
    	if($ingredient == NULL)
			throw $this->createNotFoundException('Ingredient introuvable !');

		if($ingredient->getUtilisateur() != $this->getUser() || $ingredient->getIgdValide() == 1)
			throw $this->createNotFoundException('Ingredient introuvable !');

		$form = $this->createForm(new IngredientType, $ingredient);

		$request = $this->getRequest();
		if($request->getMethod() == "POST")
		{
			$form->bind($request);
			if($form->isValid())
			{
				$em = $this->getDoctrine()->getManager();
                $ingredient->getIgdIllustration()->setType('ingredient');
                $ingredient->getIgdIllustration()->setUtilisateur($this->getUser());
				$em->persist($ingredient);
				$em->flush();

                $this->get('session')->getFlashBag()->add(
                    'alert-success',
                    'L\'ingrédient a bien été modifié !'
                );

				$url = $this->generateUrl('pp_appli_listeIngredient');
				return $this->redirect($url);
			}
		}

		return $this->render('PPAppliBundle:Ingredient:edit.html.twig', array('form' => $form->createView(), 'ingredient' => $ingredient));
    }
}
