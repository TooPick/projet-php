<?php

namespace PP\AppliBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PP\AppliBundle\Entity\Categorie;
use PP\AppliBundle\Entity\Recette;
use PP\AppliBundle\Entity\Commentaire;
use PP\AppliBundle\Form\RecetteType;
use PP\AppliBundle\Form\CommentaireType;

class AppliController extends Controller
{
    public function indexAction()
	{
		$recettes = NULL;
		
		$em = $this->getDoctrine()->getManager();
		$recetteRepository = $em->getRepository('PPAppliBundle:Recette');
		
		$recettes = $recetteRepository->findBy(array('rctStatut' => 'finale'), array('rctDate' => 'DESC'));
		
        return $this->render('PPAppliBundle:Pages:index.html.twig', array('recettes' => $recettes));
    }
	
	public function recetteListeAction($idCat)
	{
		$categories = NULL;
		$recettes = NULL;
		
		$em = $this->getDoctrine()->getManager();
		$categorieRepository = $em->getRepository('PPAppliBundle:Categorie');
	
		if($idCat == 0)
		{			
			$categories = $categorieRepository->findAll();
		}
		else
		{
			$categories = $categorieRepository->find($idCat);
			if(empty($categories))
			{
				$url = $this->generateUrl('pp_appli_recetteListe');
				return $this->redirect($url);
			}
			
			$recetteRepository = $em->getRepository('PPAppliBundle:Recette');
			$recettes = $recetteRepository->findBy(array('categorie' => $idCat, 'rctStatut' => 'finale'));
		}
	
		return $this->render('PPAppliBundle:Pages:recetteListe.html.twig', array('idCat' => $idCat, 'categories' => $categories, 'recettes' => $recettes));
	}
	
	public function recetteDetailAction(Recette $recette = NULL)
	{		
		if($recette == NULL || $recette->getRctStatut() != 'finale')
		{
			$url = $this->generateUrl('pp_appli_recetteListe');
			return $this->redirect($url);
		}
		$em = $this->getDoctrine()->getManager();
		$commentaireRepository = $em->getRepository('PPAppliBundle:Commentaire');
		$commentaires = $commentaireRepository->findBy(array('recette' => $recette), array('comDate' => 'DESC'));
		
		$commentaire = new Commentaire();
		$form = $this->createForm(new CommentaireType, $commentaire);
		
		$request = $this->get('request');
		if($request->getMethod() == "POST")
		{
			$form->bind($request);
			if($form->isValid())
			{
				$commentaire->setRecette($recette);
				$commentaire->setUtilisateur($this->getUser());
				$em->persist($commentaire);
				$em->flush();
				
				$url = $this->generateUrl('pp_appli_recetteDetail', array('id' => $recette->getId()));
				return $this->redirect($url);
			}
		}
	
		return $this->render('PPAppliBundle:Pages:recetteDetail.html.twig', array('recette' => $recette, 'form' => $form->createView(), 'commentaires' => $commentaires));
	}

	public function searchAction()
	{
		$request = $this->getRequest();
		if($request->getMethod() == "POST")
		{
			extract($_POST);
			if($search == NULL)
			{
				$url = $this->generateUrl('pp_appli_index');
				return $this->redirect($url);
			}
			else
			{
				$em = $this->getDoctrine()->getManager();
				$recetteRepository = $em->getRepository('PPAppliBundle:Recette');

				$result = $recetteRepository->searchRecette($search);

				return $this->render("PPAppliBundle:Pages:search.html.twig", array('result' => $result, 'search' => $search));
			}
		}
		else
		{
			$url = $this->generateUrl('pp_appli_index');
			return $this->redirect($url);
		}
	}
	
	public function nouveautesAction($page)
	{
		if($page == 0)
		{
			$url = $this->generateUrl('pp_appli_nouveautes');
			return $this->redirect($url);
		}

		$em = $this->getDoctrine()->getManager();
		$recetteRepository = $em->getRepository('PPAppliBundle:Recette');
		
		$recettes = $recetteRepository->findBy(array('rctStatut' => 'finale'), array('rctDate' => 'DESC'));
		
		$nombrePages = ceil(count($recettes)/9);
		if($page > $nombrePages)
		{
			$url = $this->generateUrl('pp_appli_nouveautes', array('page' => $nombrePages));
			return $this->redirect($url);
		}

		return $this->render('PPAppliBundle:Pages:nouveautes.html.twig', array('recettes' =>$recettes, 'page' => $page, 'nombrePages' => $nombrePages));
	}
}
