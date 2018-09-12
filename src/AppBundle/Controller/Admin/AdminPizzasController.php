<?php
/**
 * Created by PhpStorm.
 * User: Alexis
 * Date: 23/11/2017
 * Time: 19:13
 */

namespace AppBundle\Controller\Admin;


use AppBundle\Entity\Pizzas;
use AppBundle\Form\PizzasType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("/admin")
*/
class AdminPizzasController extends Controller
{

    /**
     * @Route("/pizzas", name="app.admin.pizzas")
     *
     */
    public function adminAction()
    {

        $doctrine = $this->getDoctrine();

        $results = $doctrine->getRepository(Pizzas::class)->getResults();

        return $this->render('admin/admin_pizzas.html.twig', ['results'=>$results]);

    }

    /**
     * @Route("/add_pizza", name="app.admin.add_pizza", defaults={"id" = Null})
     * @Route("/add_pizza/update/{id}", name="app.admin.update_pizza")
     */
    public function addModifyPizza(Request $request, $id)
    {
        $doctrine = $this->getDoctrine();

        $em = $doctrine->getManager();
        $rc = $doctrine->getRepository(Pizzas::class);

        // objets nécéssaires à la création du form
        $entity = $entity = $id ? $rc->find($id) : new Pizzas();
        $entityType = PizzasType::class;

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
            $message = $id ? 'La pizza à été modifiée' : 'La nouvelle pizza a été ajoutée au catalogue';

            // message flash: clé valeur
            $this->addFlash('notice', $message);

            return $this->redirectToRoute('app.admin.pizzas', []);
        }
        return $this->render('admin/add_pizza.html.twig', ['form'=>$form->createView()]);

    }

    /**
     * @Route("/deletepizza/{id}", name="app.admin.delete_pizza")
     */
    public function deletePizza($id) {

        $doctrine = $this->getDoctrine();

        $entity = $doctrine->getRepository(Pizzas::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($entity);
        $em->flush();

        //message de confirmation
        $message = 'La pizza à été supprimée.';
        $this->addFlash('notice', $message);

        //redirection

        return $this->redirectToRoute('app.admin.pizzas');


    }


}