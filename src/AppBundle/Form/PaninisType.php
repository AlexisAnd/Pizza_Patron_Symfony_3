<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class PaninisType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, [
            'constraints' => [
                new NotBlank([
                    'message' => "Vous n'avez pas saisi le nom du panini."
                ]),
                new Length([
                    'min' =>3,
                    'max' => 15,
                    'minMessage' => "le nom du panini doit comporter {{ limit }} lettres au minimum",
                    'maxMessage' => "le nom du panini ne peut pas dépasser {{ limit }} caractères"
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
            ->add('price',TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Vous n'avez pas saisi Le prix."
                    ]),
                    new Length([
                        'max' => 3,
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
            'data_class' => 'AppBundle\Entity\Paninis'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_paninis';
    }


}
