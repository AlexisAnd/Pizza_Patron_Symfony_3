<?php
/**
 * Created by PhpStorm.
 * User: Alexis
 * Date: 17/11/2017
 * Time: 19:06
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Token;
use AppBundle\Events\UpdatePasswordCompleteEvent;
use AppBundle\Events\UserEvent;
use AppBundle\Form\TokenType;
use AppBundle\Form\UserType;
use AppBundle\Repository\TokenRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class LogController extends Controller
{

    /**
     * @Route("/login", name="app.user.login")
     *
     */
    public function loginAction(Request $request, AuthenticationUtils $authUtils) {


        $session = $request->getSession();
        $maxfailures = $this->getParameter('number_failures');


       if($session->get('number_failures') == $maxfailures) {
           $message = 'Si vous avez oublié votre mot de passe, nous pouvons le réinitialiser ensemble';

           $this->addFlash('notice', $message);

           $session->remove('number_failures');

           return $this->redirectToRoute('app.account.password_recovery');
       }
        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('user/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    /**
     * @Route("/logout", name="app.user.logout")
     *
     */
    public function logoutAction()
    {

        //voir security.yml pour le code

    }

    /**
     * @Route("/redirect", name="app.user.redirect")
     */
    public function redirectAction(Request $request)
    {
        $user = $this->getUser();

        if (in_array('ROLE_USER', $user->getRoles())) {
            $username = $user->getFirstName();
            $message = 'bienvenue sur votre compte ' . $username;

            $this->addFlash('notice', $message);
            return $this->redirectToRoute('app.default.index');
        } else {

            $message = 'bienvenue admin';

            $this->addFlash('notice', $message);

            return $this->redirectToRoute('app.admin.admin');

        }
    }

    /**
     * @Route("/password_recovery", name="app.account.password_recovery")
     */
    public function passwordRecoveryAction(Request $request) {

        //doctrine
        $doctrine = $this->getDoctrine();

        $em = $doctrine->getManager();

        $entity = new Token();
        $entityType = TokenType::class;

        $form = $this->createForm($entityType, $entity);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            $em->persist($data);
            $em->flush();

            $message = 'Votre allez recevoir un email. Cliquez sur le lien pour 
                        reinitialiser votre mot de passe';

            $this->addFlash('notice', $message);

        }

        return $this->render('account/password_recovery.html.twig',['form'=>$form->createView()]);

    }


    /**
     * @Route("/account/modify_password/{email}/{token}", name="app.account.modify_password")
     */
    public function modifyPasswordAction($email, $token, Request $request)
    {
        $doctrine = $this->getDoctrine();

        $results = $doctrine->getRepository(Token::class)->getResults($email, $token);


        if ($results != null) {

            $em = $doctrine->getManager();

            //recuperer l'utilisateur par son email
            $entity = $doctrine->getRepository(User::class)->findOneBy(['username'=>$email]);
            $type = UserType::class;

            $form = $this->createForm($type, $entity);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $data = $form->getData();

                $em->persist($data);

                $em->flush();

                //service déclencheur d'evenements
                $eventDispatcher = $this->get('event_dispatcher');

                //on instancie l'evenement:
                $event = new UpdatePasswordCompleteEvent();
                $event->setEmail($email);
                $event->setToken($token);

                //déclencheur de l'evenement:
                $eventDispatcher->dispatch(UserEvent::UPDATE_PASSWORD_COMPLETE, $event);

                $message = 'Votre mot de passe est modifié. 
                            Vous pouvez vous connecter à votre compte';

                $this->addFlash('notice', $message);


                return $this->redirectToRoute('app.user.login');
            }

            return $this->render('account/modify_password.html.twig', ['form' => $form->createView()]
            );

        }

    }

}