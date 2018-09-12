<?php
/**
 * Created by PhpStorm.
 * User: Alexis
 * Date: 24/11/2017
 * Time: 13:12
 */

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Paninis;
use AppBundle\Form\PaninisType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("/admin")
 */
class AdminPaninisController extends Controller
{

    /**
     * @Route("/paninis", name="app.admin.paninis")
     *
     */
    public function adminAction()
    {

        $doctrine = $this->getDoctrine();

        $results = $doctrine->getRepository(Paninis::class)->getResults();

        return $this->render('admin/admin_paninis.html.twig', ['results'=>$results]);

    }

    /**
     * @Route("/add_paninis", name="app.admin.add_paninis", defaults={"id" = Null})
     * @Route("/add_paninis/update/{id}", name="app.admin.update_paninis")
     */
    public function addModifyPaninis(Request $request, $id)
    {
        $doctrine = $this->getDoctrine();

        $em = $doctrine->getManager();
        $rc = $doctrine->getRepository(Paninis::class);

        // objets nécéssaires à la création du form
        $entity = $entity = $id ? $rc->find($id) : new Paninis();
        $entityType = PaninisType::class;

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
            $message = $id ? 'Le panini à été modifié' : 'La nouveau panini a été ajouté au catalogue';

            // message flash: clé valeur
            $this->addFlash('notice', $message);

            return $this->redirectToRoute('app.admin.paninis', []);
        }
        return $this->render('admin/add_paninis.html.twig', ['form'=>$form->createView()]);

    }

    /**
     * @Route("/deletepanini/{id}", name="app.admin.delete_paninis")
     */
    public function deletePaninis($id) {

        $doctrine = $this->getDoctrine();

        $entity = $doctrine->getRepository(Paninis::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($entity);
        $em->flush();

        //message de confirmation
        $message = 'Le panini à été supprimée.';
        $this->addFlash('notice', $message);

        //redirection

        return $this->redirectToRoute('app.admin.paninis');


    }

}