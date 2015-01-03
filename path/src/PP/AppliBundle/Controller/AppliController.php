<?php

namespace PP\AppliBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PP\AppliBundle\Entity\Categorie;
use PP\AppliBundle\Entity\Recette;
use PP\AppliBundle\Entity\Commentaire;
use PP\AppliBundle\Entity\Note;
use PP\AppliBundle\Entity\Menu;

use PP\AppliBundle\Form\RecetteType;
use PP\AppliBundle\Form\CommentaireType;
use PP\AppliBundle\Form\NoteType;

class AppliController extends Controller
{
    public function indexAction()
	{
		$recettes = NULL;
		
		$em = $this->getDoctrine()->getManager();
		$recetteRepository = $em->getRepository('PPAppliBundle:Recette');

		$noteRepository = $em->getRepository('PPAppliBundle:Note');

		$populaire = $noteRepository->populaire();
		
		$recettes = $recetteRepository->findBy(array('rctStatut' => 'finale'), array('rctDate' => 'DESC'));

		$all = $recetteRepository->findBy(array('rctStatut' => 'finale'));

		if($all != NULL && count($all) >= 3)
			$nbHasard = array_rand($all, 3);
		else
			$nbHasard = array();

		$tab = array();
		foreach ($nbHasard as $id)
			$tab[] = $all[$id];
		
        return $this->render('PPAppliBundle:Pages:index.html.twig', array('recettes' => $recettes, 'hasard' => $tab, 'populaire' => $populaire, 'all' => $all));
    }
	
	public function recetteListeAction($idCat, $page)
	{
		$categories = NULL;
		$recettes = NULL;
		$nombrePages = NULL;
		
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
			$recettes = $recetteRepository->findBy(array('categorie' => $idCat, 'rctStatut' => 'finale'), array('rctTitre' => 'ASC'));

			$nombrePages = ceil(count($recettes)/9);
			if($page > $nombrePages)
			{
				$url = $this->generateUrl('pp_appli_recetteListe', array('idCat' => $idCat, 'page' => $nombrePages));
				return $this->redirect($url);
			}
		}
	
		return $this->render('PPAppliBundle:Pages:recetteListe.html.twig', array('idCat' => $idCat, 'categories' => $categories, 'recettes' => $recettes, 'page' => $page, 'nombrePages' => $nombrePages));
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

		$note = new Note();
		$noteForm = $this->createForm(new NoteType, $note);

		$noteRepository = $em->getRepository('PPAppliBundle:Note');
		$noteUtilisateur = $noteRepository->findOneBy(array('recette' => $recette, 'utilisateur' => $this->getUser()));

		$menuRepository = $em->getRepository('PPAppliBundle:Menu');
		$menus = $menuRepository->findBy(array('utilisateur' => $this->getUser()));

		$createur = ($this->getUser() == $recette->getUtilisateur());

		$noteGenerale = $noteRepository->noteGenerale($recette);
		
		$request = $this->get('request');
		if($request->getMethod() == "POST")
		{
			if ($request->request->has('pp_applibundle_note'))
			{
           		$noteForm->bind($request);
				if($noteForm->isValid())
				{
					$note->setRecette($recette);
					$note->setUtilisateur($this->getUser());
					$em->persist($note);
					$em->flush();

					$this->get('session')->getFlashBag()->add(
	                    'alert-success',
	                    'Votre note a bien été sauvegardée !'
	                );
					
					$url = $this->generateUrl('pp_appli_recetteDetail', array('id' => $recette->getId()));
					return $this->redirect($url);
				}
	        }
	 
	        if ($request->request->has('pp_applibundle_commentaire'))
	        {
	            $form->bind($request);
				if($form->isValid())
				{
					$commentaire->setRecette($recette);
					$commentaire->setUtilisateur($this->getUser());
					$em->persist($commentaire);
					$em->flush();

					$this->get('session')->getFlashBag()->add(
	                    'alert-success',
	                    'Votre commentaire a bien été ajouté !'
	                );
					
					$url = $this->generateUrl('pp_appli_recetteDetail', array('id' => $recette->getId()));
					return $this->redirect($url);
				}
	        }
		}
	
		return $this->render('PPAppliBundle:Pages:recetteDetail.html.twig', array('recette' => $recette, 'form' => $form->createView(), 'commentaires' => $commentaires, 'noteForm' => $noteForm->createView(), 'noteUtilisateur' => $noteUtilisateur, 'createur' => $createur, 'noteGenerale' => $noteGenerale, 'menus' => $menus));
	}

	public function searchAction($page)
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

	public function populaireAction($page)
	{
		if($page == 0)
		{
			$url = $this->generateUrl('pp_appli_populaire');
			return $this->redirect($url);
		}

		$em = $this->getDoctrine()->getManager();
		$recetteRepository = $em->getRepository('PPAppliBundle:Recette');
		$noteRepository = $em->getRepository('PPAppliBundle:Note');

		$populaire = $noteRepository->populaire();
		
		$recettes = $recetteRepository->findAll();
		
		$nombrePages = ceil(count($populaire)/9);
		if($page > $nombrePages)
		{
			$url = $this->generateUrl('pp_appli_populaire', array('page' => $nombrePages));
			return $this->redirect($url);
		}

		return $this->render('PPAppliBundle:Pages:populaire.html.twig', array('populaire' => $populaire, 'recettes' =>$recettes, 'page' => $page, 'nombrePages' => $nombrePages));
	}
}
