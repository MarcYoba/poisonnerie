<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom Complet ou Raison Sociale',
                'attr' => [
                    'placeholder' => 'ex: Hôtel de la Côte / Mme. Nicole Mbarga',
                    'class' => 'form-control',
                ],
            ])
            ->add('telephone', TelType::class, [
                'label' => 'Numéro de Téléphone',
                'required' => false,
                'attr' => [
                    'placeholder' => 'ex: +237 699 00 00 00',
                    'class' => 'form-control',
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse Email (Optionnel)',
                'required' => false,
                'attr' => [
                    'placeholder' => 'ex: contact@restaurant.cm',
                    'class' => 'form-control',
                ],
            ])
            ->add('typeClient', ChoiceType::class, [
                'label' => 'Catégorie d\'Acheteur',
                'choices' => [
                    'Particulier (Comptant)' => 'PARTICULIER',
                    'Restaurant / Traiteur' => 'RESTAURANT',
                    'Grossiste / Mareyeur' => 'GROSSISTE',
                    'Revendeur Local' => 'REVENDEUR',
                ],
                'attr' => [
                    'class' => 'form-select',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
