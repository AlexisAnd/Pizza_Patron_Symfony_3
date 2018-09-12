<?php
/**
 * Created by PhpStorm.
 * User: Alexis
 * Date: 16/11/2017
 * Time: 18:56
 */

namespace AppBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;


use Symfony\Component\HttpFoundation\Request;

class AccountController extends Controller
{

    /**
     * @Route("/register", name="app.account.register")
     */

    public function registerAction(Request $request) {

        //doctrine
        $doctrine = $this->getDoctrine();

        $em = $doctrine->getManager();
        $rc = $doctrine->getRepository(User::class);

        // objets nécéssaires à la création du form
        $entity = new User(); // Si id existe deja, trouve la,
        //sinon crée un form vide pour nouveau contact
        $entityType = UserType::class;

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
            $message = 'Votre compte est crée, Vous pouvez vous y connecter';

            // message flash: clé valeur
            $this->addFlash('notice', $message);

            return $this->redirectToRoute('app.user.login', []);
        }
        return $this->render('account/register.html.twig', ['form'=>$form->createView()]);
    }
}