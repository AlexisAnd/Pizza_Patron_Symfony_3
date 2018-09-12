<?php
/**
 * Created by PhpStorm.
 * User: Alexis
 * Date: 24/11/2017
 * Time: 14:41
 */

namespace AppBundle\Controller\Admin;


use AppBundle\Entity\Desserts;
use AppBundle\Form\DessertsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class AdminDessertsController extends Controller
{

    /**
     * @Route("/desserts", name="app.admin.desserts")
     *
     */
    public function adminAction()
    {

        $doctrine = $this->getDoctrine();

        $results = $doctrine->getRepository(Desserts::class)->getResults();

        return $this->render('admin/admin_desserts.html.twig', ['results'=>$results]);

    }

    /**
     * @Route("/add_desserts", name="app.admin.add_desserts", defaults={"id" = Null})
     * @Route("/add_desserts/update/{id}", name="app.admin.update_desserts")
     */
    public function addModifyDesserts(Request $request, $id)
    {
        $doctrine = $this->getDoctrine();

        $em = $doctrine->getManager();
        $rc = $doctrine->getRepository(desserts::class);

        // objets nécéssaires à la création du form
        $entity = $entity = $id ? $rc->find($id) : new desserts();
        $entityType = DessertsType::class;

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
            $message = $id ? 'Le dessert à été modifié' : 'Le nouveau dessert a été ajouté au catalogue';

            // message flash: clé valeur
            $this->addFlash('notice', $message);

            return $this->redirectToRoute('app.admin.desserts', []);
        }
        return $this->render('admin/add_desserts.html.twig', ['form'=>$form->createView()]);

    }

    /**
     * @Route("/deletedessert/{id}", name="app.admin.delete_desserts")
     */
    public function deleteDesserts($id) {

        $doctrine = $this->getDoctrine();

        $entity = $doctrine->getRepository(Desserts::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($entity);
        $em->flush();

        //message de confirmation
        $message = 'Le dessert à été supprimé.';
        $this->addFlash('notice', $message);

        //redirection

        return $this->redirectToRoute('app.admin.desserts');


    }


}