<?php

namespace PP\AppliBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PP\AppliBundle\Entity\Menu;
use PP\AppliBundle\Entity\Recette;

use PP\AppliBundle\Form\MenuType;

class MenuController extends Controller
{
    public function listeAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('PPAppliBundle:Menu');

    	$menus = $repository->findBy(array('utilisateur' => $this->getUser()));

    	return $this->render('PPAppliBundle:Menu:liste.html.twig', array('menus' => $menus));
    }

    public function ajouterAction()
    {
    	$menu = new Menu();
    	$form = $this->createForm(new MenuType, $menu);

    	$request = $this->getRequest();
    	if($request->getMethod() == "POST")
    	{
    		$form->bind($request);
    		if($form->isValid())
    		{
    			$em = $this->getDoctrine()->getManager();
    			$menu->setUtilisateur($this->getUser());
    			$em->persist($menu);
    			$em->flush();

    			$this->get('session')->getFlashBag()->add(
                    'alert-success',
                    'Le menu a bien été ajouté !'
                );

    			$url = $this->generateUrl('pp_appli_menus');
    			return $this->redirect($url);
    		}
    	}

    	return $this->render('PPAppliBundle:Menu:ajouter.html.twig', array('form' => $form->createView()));
    }

    public function supprimerAction(Menu $menu = NULL)
    {
    	if($menu == NULL || $menu->getUtilisateur() != $this->getUser())
    		throw $this->createNotFoundException('Menu Introuvable !');

    	$em = $this->getDoctrine()->getManager();
    	$em->remove($menu);
    	$em->flush();

    	$this->get('session')->getFlashBag()->add(
            'alert-success',
            'Le menu a bien été supprimé !'
        );

    	$url = $this->generateUrl('pp_appli_menus');
    	return $this->redirect($url);
    }

    public function ajouterRecetteAction(Recette $recette = NULL)
    {
    	if($recette == NULL)
    		throw $this->createNotFoundException('Recette Introuvable !');

    	$request = $this->getRequest();
    	if($request->getMethod() == "POST")
    	{
    		if(isset($_POST['menu']))
    		{
    			extract($_POST);

    			$em = $this->getDoctrine()->getManager();
		    	$repository = $em->getRepository('PPAppliBundle:Menu');

		    	$menu = $repository->findOneBy(array('utilisateur' => $this->getUser(), 'id' => $menu));

		    	if($menu == NULL)
    				throw $this->createNotFoundException('Menu Introuvable !');

    			$menu->addRecette($recette);
    			$em->persist($menu);
    			$em->flush();
    		}
    	}

    	$url = $this->generateUrl('pp_appli_menus');
    	return $this->redirect($url);
    }

    public function supprimerRecetteAction(Menu $menu = NULL, $idRecette)
    {
    	if($menu == NULL || $menu->getUtilisateur() != $this->getUser())
    		throw $this->createNotFoundException('Menu Introuvable !');

    	$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('PPAppliBundle:Recette');

		$recette = $repository->find($idRecette);

		if($recette == NULL)
    		throw $this->createNotFoundException('Recette Introuvable !');

    	$menu->removeRecette($recette);
    	$em->persist($menu);
    	$em->flush();

    	$this->get('session')->getFlashBag()->add(
            'alert-success',
            'La recette a bien été supprimée du menu !'
        );

    	$url = $this->generateUrl('pp_appli_editerRecettesMenu', array('id' => $menu->getId()));
    	return $this->redirect($url);
    }

    public function editerRecettesAction(Menu $menu = NULL)
    {
    	if($menu == NULL || $menu->getUtilisateur() != $this->getUser())
    		throw $this->createNotFoundException('Menu Introuvable !');

    	return $this->render('PPAppliBundle:Menu:editerRecettes.html.twig', array('menu' => $menu));
    }

    public function listeIngredientsAction(Menu $menu = NULL)
    {
    	if($menu == NULL || $menu->getUtilisateur() != $this->getUser())
    		throw $this->createNotFoundException('Menu Introuvable !');

    	return $this->render('PPAppliBundle:Menu:listeIngredients.html.twig', array('menu' => $menu));
    }
}
