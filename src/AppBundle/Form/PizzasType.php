<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class PizzasType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, [
            'constraints' => [
                new NotBlank([
                    'message' => "Vous n'avez pas saisi le nom de la pizza."
                ]),
                new Length([
                    'min' =>3,
                    'max' => 50,
                    'minMessage' => "Le nom doit comporter {{ limit }} lettres au minimum",
                    'maxMessage' => "Le nom ne peut pas dépasser {{ limit }} caractères"
                ]),
                new Regex([
                    'pattern' => "/^[a-zA-Z \' -]+$/",
                    'message' => 'Le nom ne peut pas comporter de chiffres.'
                ])
            ]
        ])
                ->add('description', TextType::class, [
                    'constraints' => [
                        new NotBlank([
                            'message' => "Vous n'avez pas saisi de description."
                        ]),
                    ]
                ])
                ->add('pricejunior',TextType::class, [
                    'constraints' => [
                        new NotBlank([
                            'message' => "Vous n'avez pas saisi Le prix Junior."
                        ]),
                        new Length([
                            'max' => 3,
                            'maxMessage' => 'Le prix Junior ne peut pas depasser {{ limit }} chiffres'
                        ]),
                        new Regex([
                            'pattern' => "/^[0-9]+$/",
                            'message' => 'Le prix Junior ne peut pas comporter de lettres.'
                        ])
                    ]
                ])
                ->add('pricemedium',TextType::class, [
                    'constraints' => [
                        new NotBlank([
                            'message' => "Vous n'avez pas saisi Le prix Medium."
                        ]),
                        new Length([
                            'max' => 3,
                            'maxMessage' => 'Le prix Medium ne peut pas depasser {{ limit }} chiffres'
                        ]),
                        new Regex([
                            'pattern' => "/^[0-9]+$/",
                            'message' => 'Le prix Medium ne peut pas comporter de lettres.'
                        ])
                    ]
                ])
                ->add('pricesenor',TextType::class, [
                    'constraints' => [
                        new NotBlank([
                            'message' => "Vous n'avez pas saisi Le prix Senor."
                        ]),
                        new Length([
                            'max' => 3,
                            'maxMessage' => 'Le prix Senor ne peut pas depasser {{ limit }} chiffres'
                        ]),
                        new Regex([
                            'pattern' => "/^[0-9]+$/",
                            'message' => 'Le prix Senor ne peut pas comporter de lettres.'
                        ])
                    ]
                ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Pizzas'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_pizzas';
    }


}
