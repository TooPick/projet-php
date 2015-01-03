<?php

namespace PP\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PP\AppliBundle\Entity\Categorie;

use PP\AppliBundle\Form\CategorieType;



use PP\AppliBundle\Entity\Image;
use PP\AppliBundle\Form\ImageType;

class CategorieController extends Controller
{
	public function listeAction()
	{
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('PPAppliBundle:Categorie');

		$categories = $repository->findAll();

		return $this->render('PPAdminBundle:Categorie:liste.html.twig', array('categories' => $categories));
	}

	public function ajouterAction()
	{
		$categorie = new Categorie();
		$form = $this->createForm(new CategorieType, $categorie);

		$request = $this->getRequest();
		if($request->getMethod() == "POST")
		{
			$form->bind($request);
			if($form->isValid())
			{
				$em = $this->getDoctrine()->getManager();
				$categorie->getCatIllustration()->setType('categorie');
				$em->persist($categorie);
				$em->flush();

				$this->get('session')->getFlashBag()->add(
                    'alert-success',
                    'La catégorie a bien été ajoutée !'
                );

				$url = $this->generateUrl('pp_admin_listeCategories');
				return $this->redirect($url);
			}
		}

		return $this->render('PPAdminBundle:Categorie:ajouter.html.twig', array('form' => $form->createView(), 'categorie' => $categorie));
	}

	public function editAction(Categorie $categorie = NULL)
	{
		if($categorie == NULL)
			throw $this->createNotFoundException("Catégorie introuvable !");

		$form = $this->createForm(new CategorieType, $categorie);

		$request = $this->getRequest();
		if($request->getMethod() == "POST")
		{
			$form->bind($request);
			if($form->isValid())
			{
				$em = $this->getDoctrine()->getManager();
				$categorie->getCatIllustration()->setType('categorie');
				$em->persist($categorie);
				$em->flush();

				$this->get('session')->getFlashBag()->add(
                    'alert-success',
                    'La catégorie a bien été modifiée !'
                );

				$url = $this->generateUrl('pp_admin_listeCategories');
				return $this->redirect($url);
			}
		}

		return $this->render('PPAdminBundle:Categorie:edit.html.twig', array('form' => $form->createView(), 'categorie' => $categorie));
	}

	public function supprAction(Categorie $categorie = NULL)
	{
		if($categorie == NULL)
			throw $this->createNotFoundException("Catégorie introuvable !");

		$em = $this->getDoctrine()->getManager();
		$em->remove($categorie);
		$em->flush();

		$this->get('session')->getFlashBag()->add(
            'alert-success',
            'La catégorie a bien été supprimée !'
        );

		$url = $this->generateUrl('pp_admin_listeCategories');
		return $this->redirect($url);
	}
}
