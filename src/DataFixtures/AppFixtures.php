<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Contact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categorie = new Categorie();
        $categorie ->setDesignation('amis');
        $manager->persist($categorie);

        $cat = new Categorie();
        $cat ->setDesignation('professionnels');
        $manager->persist($cat);

        $cate = new Categorie();
        $cate ->setDesignation('connaissances');
        $manager->persist($cate);

        $faker = Factory::create("fr-FR");
        for ($i = 1; $i <= 20; $i++) {
            $article = new Contact();

            $Image = $faker->imageUrl(80, 80);
            $adresse = $faker->address;
            $prenom = $faker->name;
            $nom = $faker->lastName;
            $ville = $faker->city;
            $tele = $faker->phoneNumber;
            $email = $faker->email;
            $postale = $faker->countryCode;
            $categories = [$cat, $categorie, $cate];
            $j =(mt_rand(0, 2));
            $article
                ->setCategorie($categories[$j])
                ->setNumTele($tele)
                ->setEmail($email)
                ->setVille($ville)
                ->setCodePostal($postale)
                ->setNom($nom)
                ->setPrenom($prenom)
                ->setAdresse($adresse)
                ->setImage($Image);


            $manager->persist($article);
        }

            $manager->flush();
    }

}
