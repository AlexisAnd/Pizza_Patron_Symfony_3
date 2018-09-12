<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Regex;

class UserType extends AbstractType
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
        $builder->add('firstName', TextType::class, [
            'constraints' => [
                new NotBlank([
                    'message' => "Vous n'avez pas saisi votre prénom."
                ]),
                new Length([
                    'min' => 2,
                    'max' => 50,
                    'minMessage' => "Votre prénom  doit comporter {{ limit }} lettres au minimum",
                    'maxMessage' => "Votre prénom ne peut pas dépasser {{ limit }} caractères"
                ]),
                new Regex([
                    'pattern' => "/^[a-zA-Z \' -]+$/",
                    'message' => 'Votre prénom ne peut pas comporter de chiffres.'
                ])
            ]
        ])
            ->add('lastName', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Vous n'avez pas saisi votre nom de famille."
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 50,
                        'minMessage' => "Votre nom de famille  doit comporter {{ limit }} lettres au minimum",
                        'maxMessage' => "Votre nom de famille ne peut pas dépasser {{ limit }} caractères"
                    ]),
                    new Regex([
                        'pattern' => "/^[a-zA-Z \' -]+$/",
                        'message' => 'Votre nom de famille ne peut pas comporter de chiffres.'
                    ])
                ]
            ])
            ->add('address', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Vous n'avez pas saisi votre adresse."
                    ]),
                    new Length([
                        'min' => 5,
                        'max' => 50,
                        'minMessage' => "Votre adresse  doit comporter {{ limit }} lettres au minimum",
                        'maxMessage' => "Votre adresse ne peut pas dépasser {{ limit }} caractères"
                    ]),
                ]
            ])
            ->add('city', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Vous n'avez pas saisi votre ville."
                    ]),
                    new Length([
                        'min' => 5,
                        'max' => 5,
                        'minMessage' => "Pizza Patron effectue des livraisons sur la ville de Paris uniquement",
                        'maxMessage' => "Pizza Patron effectue des livraisons sur la ville de Paris uniquement"
                    ]),
                    new Regex([
                        'pattern' => "/^[a-zA-Z \' -]+$/",
                        'message' => 'Votre ville ne peut pas comporter de chiffres.'
                    ])
                ]
            ])
            ->add('postalCode', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Vous n'avez pas saisi votre code postal."
                    ]),
                    new Length([
                        'min' => 5,
                        'max' => 5,
                        'minMessage' => 'Votre code postal doit comporter {{ limit }} chiffres',
                        'maxMessage' => 'Votre code postal ne peut pas depasser {{ limit }} chiffres'
                    ]),
                    new Regex([
                        'pattern' => "/^[0-9]+$/",
                        'message' => 'Votre code postal ne peut pas comporter de lettres.'
                    ])
                ]
            ])
            ->add('phone', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Vous n'avez pas saisi votre numéro de téléphone."
                    ]),
                    new Length([
                        'min' => 10,
                        'max' => 10,
                        'minMessage' => 'Votre numéro de téléphone doit comporter {{ limit }} chiffres',
                        'maxMessage' => 'Votre numéro de téléphone ne peut pas depasser {{ limit }} chiffres'
                    ]),
                    new Regex([
                        'pattern' => "/^[0-9]+$/",
                        'message' => 'Votre numéro de téléphone ne peut pas comporter de lettres.'
                    ])
                ]
            ])
            ->add('username', EmailType::class, [
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
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les champs de mot de passe doivent être identiques',
                'options' => array('attr' => array('class' => 'password-field')),
                'required' => true,
                'first_options' => array('label' => 'Mot de passe:'),
                'second_options' => array('label' => 'Repetez le mot de passe:'),
                'constraints' => [
                    new NotBlank([
                        'message' => "Vous n'avez pas saisi votre mot de passe."
                    ]),
                    new Length([
                        'min' => 8,
                        'max' => 30,
                        'minMessage' => 'Votre mot de passe doit comporter {{ limit }} lettres au minimum',
                        'maxMessage' => 'Votre mot de passe ne peut pas dépasser {{ limit }} caractères'
                    ])

                ]

            ]);

        $builder->addEventListener(FormEvents::POST_SET_DATA, [$this, 'postSetData']);
    }

            public function postSetData(FormEvent $event)
            {
                //recuperation de la saisie du formulaire
                $data = $event->getData();

                //recuperation du formulaire
                $form = $event->getForm();

                // entité
                $entity = $form->getData();

                //recupere le nom de la route
                $route = $this->request->get('_route');

                //switcher les remove selon le nom des routes
                switch ($route) {
                    case 'app.profiles.update':

                        //supprimer les champs
                        $form->remove('city');
                        $form->remove('password');


                        break;
                    case 'app.account.modify_password':

                        $form->remove('firstName');
                        $form->remove('lastName');
                        $form->remove('address');
                        $form->remove('city');
                        $form->remove('postalCode');
                        $form->remove('phone');
                        $form->remove('username');

                        break;
                }
            }


    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user';
    }


}
