<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class TokenType extends AbstractType
{

    private $request;
    private $requeststack;

    public function __construct(RequestStack $request)
    {
        $this->request = $request->getMasterRequest();
        $this->requeststack = $request;
    }
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', EmailType::class, [
            'constraints' => [
                new NotBlank([
                    'message' => "Vous n'avez pas saisi votre email."
                ]),
                new Email([
                    'message' => "Votre email semble incorrect",
                    'checkHost' => true,
                    'checkMX' => true
                ])
            ]
        ])
                ->add('token', TextType::class);


        $builder->addEventListener(FormEvents::POST_SET_DATA, [$this, 'postSetData']);
    }

    public function postSetData(FormEvent $event)
    {
        $data = $event->getData();

        $form = $event->getForm();

        $entity = $form->getData();

        $route = $this->request->get('_route');

        //switcher les remove selon le nom des routes
        switch ($route) {
            case 'app.account.password_recovery':

                //supprimer les champs
                $form->remove('token');

                break;
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Token'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_token';
    }


}
