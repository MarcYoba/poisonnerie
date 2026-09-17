<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Vente;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class VenteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $compteur = round(microtime(true) * 10); // Génère un compteur basé sur le timestamp actuel en millisecondes
        $annee = (new \DateTime())->format('Y');
        $builder
            ->add('numeroFacture', TextType::class, [
                'label' => 'N° de Facture',
                'attr' => [
                    'value' => sprintf('FAC-%s-%03d', $annee, $compteur), // Valeur par défaut
                    'class' => 'form-control',
                    'readonly' => true, // Rendre le champ en lecture seule
                ],
            ])
            ->add('createtAt', DateType::class, [ // Correction du nom de champ 'createtAt' -> 'createdAt'
                'label' => 'Date de création',
                'widget' => 'single_text', // Génère un champ HTML5 <input type="date">
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('montantTotalHt', MoneyType::class, [
                'label' => 'Montant Total HT',
                'currency' => 'XAF', // Ou 'EUR' selon vos besoins
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('remise', PercentType::class, [
                'label' => 'Remise (%)',
                'scale' => 2,
                'type' => 'fractional', // Si la valeur stockée en BDD est entre 0 et 1 (ex: 0.1 pour 10%)
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'value' => 0, // Valeur par défaut à 0%
                ],
            ])
            ->add('statuspaiement', ChoiceType::class, [
                'label' => 'Statut du paiement',
                'choices' => [
                    'Non payé' => 'NON_PAYE',
                    'Partiellement payé' => 'PARTIEL',
                    'Payé' => 'PAYE',
                ],
                'placeholder' => 'Sélectionner un statut',
                'attr' => [
                    'class' => 'form-control form-select',
                ],
            ])
            
            ->add('lignes', CollectionType::class, [
                'entry_type' => LigneVenteType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false,
                'attr' => [
                    'class' => 'lignes-vente-collection',
                ],
                'mapped' => false, // Assurez-vous que la relation est correctement mappée dans l'entité Vente
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vente::class,
        ]);
    }
}
