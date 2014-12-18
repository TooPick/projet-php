<?php

namespace PP\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PP\AppliBundle\Entity\Ingredient;

use PP\AppliBundle\Form\IngredientAdminType;

class IngredientController extends Controller
{
    public function ingredientAttenteAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('PPAppliBundle:Ingredient');

    	$ingredients = $repository->findBy(array('igdValide' => 0));

    	return $this->render('PPAdminBundle:Ingredient:attente.html.twig', array('ingredients' => $ingredients));
    }

    public function listeAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('PPAppliBundle:Ingredient');

    	$ingredients = $repository->findAll();

    	return $this->render('PPAdminBundle:Ingredient:liste.html.twig', array('ingredients' => $ingredients));
    }

    public function editIngredientAction(Ingredient $ingredient = NULL)
    {
    	if($ingredient == NULL)
			throw $this->createNotFoundException('Ingredient introuvable !');

		$form = $this->createForm(new IngredientAdminType, $ingredient);

		$request = $this->getRequest();
		if($request->getMethod() == "POST")
		{
			$form->bind($request);
			if($form->isValid())
			{
				$em = $this->getDoctrine()->getManager();
				$em->persist($ingredient);
				$em->flush();

				$url = $this->generateUrl('pp_admin_ingredientsAttente');
				return $this->redirect($url);
			}
		}

		return $this->render('PPAdminBundle:Ingredient:edit.html.twig', array('form' => $form->createView(), 'ingredient' => $ingredient));
    }

    public function supprAction(Ingredient $ingredient = NULL)
    {
        if($ingredient == NULL)
            throw $this->createNotFoundException('Ingrédient introuvable !');

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('PPAppliBundle:IngredientUnite');

        $result = $repository->findBy(array('ingredient' => $ingredient));

        foreach ($result as $ligne)
            $em->remove($ligne);

        $em->remove($ingredient);
        $em->flush();

        $url = $this->generateUrl('pp_admin_ingredientsListe');
        return $this->redirect($url);
    }
}
