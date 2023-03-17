<?php

namespace App\DataFixtures;

use App\Entity\Option;
use App\Repository\OptionRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class OptionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
      
        $options[] = new Option('Texte du copyright', 'blog_copyright', 'Tous droits réservés',
         TextType::class);
        $options[] = new Option('Nombre d\'article', 'blog_articles_limit', 5, NumberType::class);
       
        $options[] = new Option(
            'Tous le monde peut s\'inscrire',
            'user_can_register',
            true,
            CheckboxType::class
        );
        
        foreach ($options as $option) {
        
            $manager->persist($option);
        }
        $manager->flush();
    }
}
