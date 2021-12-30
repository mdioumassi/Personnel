<?php

namespace App\Form;

use App\Entity\Persons;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class PersonsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Prenom'
            ])
            ->add('birthday', BirthdayType::class, [
                'label' => 'Date de naissance',
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ],
                'attr' => [
                    'class' => 'grid'
                ]
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse'
            ])
            ->add('post', ChoiceType::class, [
                'label' => 'Titre',
                'expanded' => false,
                'multiple' => false,
                'choices' => array(
                    'Président' => 'president',
                    'Directeur' => 'directeur',
                    'Chef de projet' => 'chef de projet',
                    'Développeur' => 'developpeur'
                ),
            ])
            ->add('photo', FileType::class, [
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'custom-file-label',
                    'placeholder' => 'Choisir une image'
                ],
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png'
                        ],
                        'mimeTypesMessage' => 'Veuillez charger une image valide'
                    ])
                ]
            ])
            ->add('persons', EntityType::class, [
                'class' => Persons::class,
                'label' => 'Responsable'
            ])
//            ->add('Enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Persons::class,
        ]);
    }
}
