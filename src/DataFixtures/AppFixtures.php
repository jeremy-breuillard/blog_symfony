<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Comment;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create('fr_FR');

        // Creation d'un utilisateur
        // $user = new User();
        

        for ($i = 0; $i < 10; $i++) {
            $article = new Article();
            $article->setTitle($faker->sentence($nbWords = 2, $variableNbWords = true))
                    ->setDescription($faker->sentence($nbWords = 10, $variableNbWords = true))
                    ->setPhoto("img02.jpg")
                    ->setDate(new \Datetime());

            $manager->persist($article);
        }





        $manager->flush();
    }
}
