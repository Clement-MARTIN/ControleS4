<?php

namespace App\Form;

use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewContactType extends AbstractType
{
    /**
     * Permet d'avoir la config de base d'un champ
     * @param $label
     * @param $placeholder
     * @return array
     */
    private function getConfiguration($label, $placeholder)
    {
        return [
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
        ];
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, $this->getConfiguration("Nom", "Votre nom"))
            ->add('prenom', TextType::class, $this->getConfiguration("Prénom", "Votre prénom"))
            ->add('adresse', TextType::class, $this->getConfiguration("Adresse", "Votre adresse"))
            ->add('num_tele', TextType::class, $this->getConfiguration("Téléphone", "Votre numéro de téléphone"))
            ->add('email', TextType::class, $this->getConfiguration("L'email", "Votre email"))
            ->add('code_postal', TextType::class, $this->getConfiguration("Code postal", "Votre code postal"))
            ->add('ville', TextType::class, $this->getConfiguration("Ville", "Votre ville"))
            ->add('Categorie', EntityType::class, ['class' => Categorie::class, 'choice_label' => 'designation',])
            ->add('image', UrlType::class, $this->getConfiguration("URL de l'avatar", "Le lien"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
