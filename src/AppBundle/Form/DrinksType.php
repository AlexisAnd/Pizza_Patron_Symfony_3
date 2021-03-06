<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class DrinksType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, [
            'constraints' => [
                new NotBlank([
                    'message' => "Vous n'avez pas saisi le nom de la boisson."
                ]),
                new Length([
                    'min' =>3,
                    'max' => 15,
                    'minMessage' => "le nom de la boisson doit comporter {{ limit }} lettres au minimum",
                    'maxMessage' => "le nom de la boisson ne peut pas dépasser {{ limit }} caractères"
                ]),
                new Regex([
                    'pattern' => "/^[a-zA-Z \' -]+$/",
                    'message' => 'Le nom ne peut pas comporter de chiffres.'
                ])
            ]
        ])
            ->add('price',TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Vous n'avez pas saisi Le prix."
                    ]),
                    new Length([
                        'max' => 4,
                        'maxMessage' => 'Le prix ne peut pas depasser {{ limit }} chiffres'
                    ])
                ]
            ])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Drinks'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_drinks';
    }


}
