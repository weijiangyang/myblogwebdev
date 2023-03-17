<?php

namespace App\Form;

use App\Model\WelcomeModel;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class WelcomeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('siteTitle',TextType::class,[
                'label'=> \App\Model\WelcomeModel::SITE_TITLE_LABEL,

            ])
            ->add('email',TextType::class)
            ->add('fullName', TextType::class, [
                'label' => "Nom de l'utilisateur"

            ])
            ->add('password', PasswordType::class, [
                'label' => "Mot de passe",

            ])
            ->add('submit', SubmitType::class,[
                'label'=> "Installer Symfony"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => \App\Model\WelcomeModel::class
        ]);
    }
}
