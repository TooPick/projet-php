<?php

namespace PP\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PP\AppliBundle\Entity\Unite;
use PP\AppliBundle\Entity\IngredientUnite;

use PP\AppliBundle\Form\UniteAdminType;

class UniteController extends Controller
{
    public function attenteAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('PPAppliBundle:Unite');

    	$unites = $repository->findBy(array('uniValide' => 0));

    	return $this->render('PPAdminBundle:Unite:attente.html.twig', array('unites' => $unites));
    }

    public function listeAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('PPAppliBundle:Unite');

    	$unites = $repository->findAll();

    	return $this->render('PPAdminBundle:Unite:liste.html.twig', array('unites' => $unites));
    }

    public function editAction(Unite $unite = NULL)
    {
    	if($unite == NULL)
			throw $this->createNotFoundException('Ingredient introuvable !');

		$form = $this->createForm(new UniteAdminType, $unite);

		$request = $this->getRequest();
		if($request->getMethod() == "POST")
		{
			$form->bind($request);
			if($form->isValid())
			{
				$em = $this->getDoctrine()->getManager();
				$em->persist($unite);
				$em->flush();

                $this->get('session')->getFlashBag()->add(
                    'alert-success',
                    'L\'unité a bien été modifiée !'
                );

				$url = $this->generateUrl('pp_admin_unitesAttente');
				return $this->redirect($url);
			}
		}

		return $this->render('PPAdminBundle:Unite:edit.html.twig', array('form' => $form->createView(), 'unite' => $unite));
    }

    public function supprAction(Unite $unite = NULL)
    {
        if($unite == NULL)
            throw $this->createNotFoundException('Unité introuvable !');

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('PPAppliBundle:IngredientUnite');

        $result = $repository->findBy(array('unite' => $unite));

        foreach ($result as $ligne)
            $em->remove($ligne);

        $em->remove($unite);
        $em->flush();

        $this->get('session')->getFlashBag()->add(
            'alert-success',
            'L\'unité a bien été supprimée !'
        );

        $url = $this->generateUrl('pp_admin_unitesListe');
        return $this->redirect($url);
    }

}
