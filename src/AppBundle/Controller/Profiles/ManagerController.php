<?php
/**
 * Created by PhpStorm.
 * User: Alexis
 * Date: 20/11/2017
 * Time: 14:26
 */

namespace AppBundle\Controller\Profiles;

use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
 * @Route("/profiles")
 */
class ManagerController extends Controller
{

    /**
     * @Route("/update", name="app.profiles.update")
     *
     */
    public function updateInfosAction(Request $request)
    {
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();
        $user = $this->getUser();
        $type = UserType::class;

        $form = $this->createForm($type, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            $em->persist($data);

            $em->flush();

            $message = 'Les informations sont mises à jour';

            $this->addFlash('notice', $message);

            return $this->redirectToRoute('app.profiles.usersettings', []);
        }
        return $this->render('profiles/update.html.twig', ['form' => $form->createView()]);
    }
}