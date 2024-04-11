<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Ingredient;
use App\Entity\User;
use Faker;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        $types = ['Légumes', 'Fruits', 'Épices', 'Autres'];
        
        for ($i = 0; $i < 20; $i++) {
            $ingredient = new Ingredient();
            $ingredient->setNom($faker->word());

            $randomTypeIndex = array_rand($types);
            $randomType = $types[$randomTypeIndex];
            $ingredient->setType($randomType);

            $manager->persist($ingredient);
            $manager->flush();
        }

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setPrenom($faker->firstName());
            $user->setNom($faker->lastName());
            $user->setUsername('pseudo' . $i);
            $user->setEmail($faker->email());
            $user->setRoles(['ROLE_USER']);
            $user->setPlainPassword('password');

            $manager->persist($user);
            $manager->flush();
        }
        
    }
}
