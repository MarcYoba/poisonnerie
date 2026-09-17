<?php

namespace App\Form;

use App\Entity\Employee;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom & Prénom',
                'attr' => [
                    'placeholder' => 'ex: YOBS TIE',
                    'class' => 'form-control',
                ],
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Numéro de téléphone',
                'attr' => [
                    'placeholder' => 'ex: +237 6XX XX XX XX',
                    'class' => 'form-control',
                ],
            ])
            ->add('identification', TextType::class, [
                'label' => 'N° d\'identification / CNI',
                'attr' => [
                    'placeholder' => 'ex: 123456789',
                    'class' => 'form-control',
                ],
            ])
            ->add('adresse', TextareaType::class, [
                'label' => 'Adresse / Résidence',
                'required' => false,
                'attr' => [
                    'placeholder' => 'ex: Quartier Akwa, Douala',
                    'rows' => 3,
                    'class' => 'form-control',
                ],
            ])
            ->add('contrat', ChoiceType::class, [
                'label' => 'Type de contrat',
                'choices' => [
                    'CDI' => 'CDI',
                    'CDD' => 'CDD',
                    'Stage' => 'STAGE',
                    'Prestation / Freelance' => 'FREELANCE',
                ],
                'placeholder' => 'Sélectionnez un type de contrat',
                'attr' => [
                    'class' => 'form-select',
                ],
            ])
            ->add('montant', MoneyType::class, [
                'label' => 'Salaire / Remunération',
                'currency' => 'XAF', // Changez la devise selon vos besoins (EUR, USD, XAF, etc.)
                'attr' => [
                    'placeholder' => '0.00',
                    'class' => 'form-control',
                ],
            ])
            ->add('createtAt', DateType::class, [
                'label' => 'Date de création',
                'widget' => 'single_text', // En général, la date de création est générée automatiquement et non modifiable
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employee::class,
        ]);
    }
}
