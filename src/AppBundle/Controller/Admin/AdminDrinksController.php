<?php
/**
 * Created by PhpStorm.
 * User: Alexis
 * Date: 24/11/2017
 * Time: 14:26
 */

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Drinks;
use AppBundle\Form\DrinksType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("/admin")
 */
class AdminDrinksController extends Controller
{

    /**
     * @Route("/drinks", name="app.admin.drinks")
     *
     */
    public function adminAction()
    {

        $doctrine = $this->getDoctrine();

        $results = $doctrine->getRepository(Drinks::class)->getResults();

        return $this->render('admin/admin_drinks.html.twig', ['results'=>$results]);

    }

    /**
     * @Route("/add_drinks", name="app.admin.add_drinks", defaults={"id" = Null})
     * @Route("/add_drinks/update/{id}", name="app.admin.update_drinks")
     */
    public function addModifyDrinks(Request $request, $id)
    {
        $doctrine = $this->getDoctrine();

        $em = $doctrine->getManager();
        $rc = $doctrine->getRepository(Drinks::class);

        // objets nécéssaires à la création du form
        $entity = $entity = $id ? $rc->find($id) : new drinks();
        $entityType = DrinksType::class;

        //création d'un formulaire
        $form = $this->createForm($entityType, $entity);

        //récupération de la saisie précédente contenue dans la requête.
        // Si erreur sur le formulaire, il recharge le contenu des champs.
        $form->handleRequest($request);

        // formulaire valide
        if($form->isSubmitted() && $form->isValid()) {
            // recupération de l'entité remplie avec la saisie
            $data = $form->getData();
            // exit(dump($data));

            // persistance de l'objet en base de données: ca met les requetes à la queue
            // en attente d'exectution
            $em->persist($data);

            // execution des requetes
            $em->flush();

            //message de confirmation
            $message = $id ? 'La boisson à été modifiée' : 'La nouvelle boisson a été ajoutée au catalogue';

            // message flash: clé valeur
            $this->addFlash('notice', $message);

            return $this->redirectToRoute('app.admin.drinks', []);
        }
        return $this->render('admin/add_drinks.html.twig', ['form'=>$form->createView()]);

    }

    /**
     * @Route("/deletedrink/{id}", name="app.admin.delete_drinks")
     */
    public function deleteDrinks($id) {

        $doctrine = $this->getDoctrine();

        $entity = $doctrine->getRepository(Drinks::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($entity);
        $em->flush();

        //message de confirmation
        $message = 'La boisson à été supprimée.';
        $this->addFlash('notice', $message);

        //redirection

        return $this->redirectToRoute('app.admin.drinks');


    }

}