<?php
/**
 * Created by PhpStorm.
 * User: Alexis
 * Date: 24/11/2017
 * Time: 14:26
 */

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Texmex;
use AppBundle\Form\TexmexType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("/admin")
 */
class AdminTexmexController extends Controller
{

    /**
     * @Route("/texmex", name="app.admin.texmex")
     *
     */
    public function adminAction()
    {

        $doctrine = $this->getDoctrine();

        $results = $doctrine->getRepository(Texmex::class)->getResults();

        return $this->render('admin/admin_texmex.html.twig', ['results'=>$results]);

    }

    /**
     * @Route("/add_texmex", name="app.admin.add_texmex", defaults={"id" = Null})
     * @Route("/add_texmex/update/{id}", name="app.admin.update_texmex")
     */
    public function addModifyTexmex(Request $request, $id)
    {
        $doctrine = $this->getDoctrine();

        $em = $doctrine->getManager();
        $rc = $doctrine->getRepository(Texmex::class);

        // objets nécéssaires à la création du form
        $entity = $entity = $id ? $rc->find($id) : new Texmex();
        $entityType = TexmexType::class;

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
            $message = $id ? 'Le tex-mex à été modifié' : 'La nouveau tex-mex a été ajouté au catalogue';

            // message flash: clé valeur
            $this->addFlash('notice', $message);

            return $this->redirectToRoute('app.admin.texmex', []);
        }
        return $this->render('admin/add_texmex.html.twig', ['form'=>$form->createView()]);

    }

    /**
     * @Route("/deletetexmex/{id}", name="app.admin.delete_tex-mex")
     */
    public function deleteTexmex($id) {

        $doctrine = $this->getDoctrine();

        $entity = $doctrine->getRepository(Texmex::class)->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($entity);
        $em->flush();

        //message de confirmation
        $message = 'Le tex-mex à été supprimé.';
        $this->addFlash('notice', $message);

        //redirection

        return $this->redirectToRoute('app.admin.texmex');


    }

}