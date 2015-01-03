<?php

namespace PP\AppliBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PP\AppliBundle\Entity\Liste;
use PP\AppliBundle\Entity\Ingredient;
use PP\AppliBundle\Entity\Recette;

use PP\AppliBundle\Form\ListeType;

class ListeController extends Controller
{
    public function listeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('PPAppliBundle:Liste');

        $listes = $repository->findBy(array('utilisateur' => $this->getUser()));

    	return $this->render('PPAppliBundle:Liste:liste.html.twig', array('listes' => $listes));
    }

    public function ajouterAction()
    {
        $liste = new Liste();
        $form = $this->createForm(new ListeType, $liste);

        $request = $this->getRequest();
        if($request->getMethod() == "POST")
        {
            $form->bind($request);
            if($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $liste->setUtilisateur($this->getUser());
                $em->persist($liste);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'alert-success',
                    'La liste a bien été ajoutée !'
                );

                $url = $this->generateUrl('pp_appli_listes');
                return $this->redirect($url);
            }
        }

        return $this->render('PPAppliBundle:Liste:ajouter.html.twig', array('form' => $form->createView()));
    }

    public function supprimerAction(Liste $liste = NULL)
    {
        if($liste == NULL || $liste->getUtilisateur() != $this->getUser())
            throw $this->createNotFoundException("Liste Introuvable !");

        $em = $this->getDoctrine()->getManager();
        $em->remove($liste);
        $em->flush();

        $this->get('session')->getFlashBag()->add(
            'alert-success',
            'La liste a bien été supprimée !'
        );

        $url = $this->generateUrl('pp_appli_listes');
        return $this->redirect($url);
    }

    public function gestionAction(Liste $liste = NULL)
    {
        if($liste == NULL || $liste->getUtilisateur() != $this->getUser())
            throw $this->createNotFoundException("Liste Introuvable !");

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("PPAppliBundle:Ingredient");

        $request = $this->getRequest();
        if($request->getMethod() == "POST")
        {
            if(isset($_POST['ingredient']))
            {
                extract($_POST);

                $ingredient = $repository->find($ingredient);

                if($ingredient == NULL)
                    throw $this->createNotFoundException("Ingredient Introuvable !");

                $liste->addIngredient($ingredient);
                $em->persist($liste);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'alert-success',
                    'L\'ingrédient a bien été ajouté à la liste !'
                );

                $url = $this->generateUrl('pp_appli_gestionIngredientsListe', array('id' => $liste->getId()));
                return $this->redirect($url);
            }
        }

        $ingredients =  $repository->findBy(array('igdValide' => 1), array('igdLabel' => 'ASC'));

        return $this->render('PPAppliBundle:Liste:gestion.html.twig', array('liste' => $liste, 'ingredients' => $ingredients));
    }

    public function supprimerIngredientAction(Liste $liste = NULL, $idIngredient)
    {
        if($liste == NULL || $liste->getUtilisateur() != $this->getUser())
            throw $this->createNotFoundException("Liste Introuvable !");

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("PPAppliBundle:Ingredient");

        $ingredient = $repository->find($idIngredient);

        if($ingredient == NULL)
            throw $this->createNotFoundException("Ingrédient Introuvable !");

        $liste->removeIngredient($ingredient);
        $em->persist($liste);
        $em->flush();

        $this->get('session')->getFlashBag()->add(
            'alert-success',
            'L\'ingrédient a bien été supprimé de la liste !'
        );

        $url = $this->generateUrl('pp_appli_gestionIngredientsListe', array('id' => $liste->getId()));
        return $this->redirect($url);
    }

    public function recettesAction(Liste $liste = NULL)
    {
        if($liste == NULL || $liste->getUtilisateur() != $this->getUser())
            throw $this->createNotFoundException("Liste Introuvable !");

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("PPAppliBundle:Recette");

        $recettes = $repository->findBy(array('rctStatut' => 'finale'));

        $tab = array();

        foreach ($recettes as $recette)
        {
            $nbIgd = 0;
            $count = count($recette->getIngredients());
            $loop = 1;
            foreach ($recette->getIngredients() as $ingredient)
            {
                $ingredient = $ingredient->getIngredient();
                $loop++;
                foreach ($liste->getIngredients() as $igd)
                {
                    if($ingredient->getId() == $igd->getId())
                    {
                        $nbIgd++;
                        if($loop == $count)
                            $tab[] = array($recette, $nbIgd);
                    }
                }
            }
        }

        return $this->render("PPAppliBundle:Liste:recettes.html.twig", array('liste' => $liste, 'recettes' => $tab));
    }
}
