<?php

namespace PP\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Security\Core\SecurityContext;

use PP\UserBundle\Entity\Utilisateur;
use PP\AppliBundle\Entity\Recette;
use PP\AppliBundle\Entity\Ingredient;
use PP\AppliBundle\Entity\Unite;
use PP\AppliBundle\Entity\IngredientUnite;
use PP\AppliBundle\Entity\Image;

use PP\UserBundle\Form\UtilisateurType;
use PP\UserBundle\Form\EditUtilisateurType;
use PP\AppliBundle\Form\RecetteType;
use PP\AppliBundle\Form\IngredientType;
use PP\AppliBundle\Form\UniteType;
use PP\AppliBundle\Form\IngredientUniteType;
use PP\AppliBundle\Form\ImageType;

class UserController extends Controller
{
	public function profilAction()
	{
		$em = $this->getDoctrine()->getManager();
		$recetteRepository = $em->getRepository('PPAppliBundle:Recette');
		
		$utilisateur = $this->getUser();
		
		$recettes = $recetteRepository->findBy(array('utilisateur' => $utilisateur));

		$imageRepository = $em->getRepository('PPAppliBundle:Image');
		$image = $imageRepository->findOneBy(array('utilisateur' => $utilisateur, 'type' => 'avatar'));

		if($image == NULL)
			$image = new Image();

		$form = $this->createForm(new ImageType, $image);

		$request = $this->getRequest();
		if($request->getMethod() == "POST")
		{
			$form->bind($request);
			if($form->isValid())
			{
				$image->setType('avatar');
				$image->setUtilisateur($this->getUser());
				$em->persist($image);
				$em->flush();

				$this->get('session')->getFlashBag()->add(
		            'alert-success',
		            'Votre avatar a bien été modifié !'
		        );

				$url = $this->generateUrl('pp_user_profil');
				return $this->redirect($url);
			}
		}
		
		return $this->render('PPUserBundle:Pages:profil.html.twig', array('recettes' => $recettes, 'utilisateur' => $utilisateur, 'form' => $form->createView(), 'image' => $image));
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
				//$utilisateur->setRoles(array("ROLE_ADMIN"));
				$em->persist($utilisateur);
				$em->flush();

				$this->get('session')->getFlashBag()->add(
		            'alert-success',
		            'L\'inscription a bien été effectuée !'
		        );
				
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
	
	public function editerAction()
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

				$this->get('session')->getFlashBag()->add(
		            'alert-success',
		            'Votre profil a bien été modifié !'
		        );
				
				$url = $this->generateUrl('pp_user_profil');
				return $this->redirect($url);
			}		
		}
	
		return $this->render('PPUserBundle:Pages:editer.html.twig', array('form' => $form->createView()));
	}

	public function supprimerAction()
	{
		$request = $this->getRequest();
		if($request->getMethod() == "POST")
		{
			if(isset($_POST['choix']))
			{
				extract($_POST);
				if($choix)
				{
					$user = $this->getUser();

					$this->get('security.context')->setToken(null);
					$this->get('request')->getSession()->invalidate();

					$em = $this->getDoctrine()->getManager();
					$em->remove($user);
					$em->flush();

					$this->get('session')->getFlashBag()->add(
			            'alert-success',
			            'Votre compte a bien été supprimé !'
			        );

					$url = $this->generateUrl('pp_appli_index');
					return $this->redirect($url);
				}
				else
				{
					$url = $this->generateUrl('pp_user_profil');
					return $this->redirect($url);
				}
			}
		}


		return $this->render('PPUserBundle:Pages:supprimer.html.twig');
	}

}
