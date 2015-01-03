<?php

namespace PP\AppliBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PP\AppliBundle\Entity\Unite;
use PP\AppliBundle\Entity\Recette;

use PP\AppliBundle\Form\UniteType;

class UniteController extends Controller
{
    public function listeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('PPAppliBundle:Unite');

        $unites = $repository->findBy(array('utilisateur' => $this->getUser(), 'uniValide' => 0));

        return $this->render('PPAppliBundle:Unite:liste.html.twig', array('unites' => $unites));
    }

    public function ajouterAction()
    {
    	$unite = new Unite();
    	$form = $this->createForm(new UniteType, $unite);

    	$request = $this->getRequest();
    	if($request->getMethod() == "POST")
    	{
    		$form->bind($request);
    		if($form->isValid())
    		{
    			$em = $this->getDoctrine()->getManager();
    			$unite->setUtilisateur($this->getUser());
    			$em->persist($unite);
    			$em->flush();

    			$url = $this->generateUrl('pp_user_profil');
    			return $this->redirect($url);
    		}
    	}

    	return $this->render('PPAppliBundle:Unite:ajouter.html.twig', array('form' => $form->createView()));
    }

    public function editionAction(Unite $unite = NULL)
    {
    	if($unite == NULL)
			throw $this->createNotFoundException('Unité introuvable !');

		if($unite->getUtilisateur() != $this->getUser() || $unite->getUniValide() == 1)
			throw $this->createNotFoundException('Unité introuvable !');

		$form = $this->createForm(new UniteType, $unite);

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

				$url = $this->generateUrl('pp_appli_listeUnite');
				return $this->redirect($url);
			}
		}

		return $this->render('PPAppliBundle:Unite:edit.html.twig', array('form' => $form->createView(), 'unite' => $unite));
    }
}
