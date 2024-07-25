<?php

namespace App\DataFixtures;

use App\Entity\Restaurant;
use App\Entity\RestaurantPicture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class RestaurantPictureFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $restaurants = $manager->getRepository(Restaurant::class)->findAll();

        foreach ($restaurants as $restaurant) {
            $numberOfPictures = $faker->numberBetween(1, 5); // Générer entre 1 et 5 images par restaurant

            for ($i = 0; $i < $numberOfPictures; $i++) {
                $restaurantPicture = new RestaurantPicture();
                $restaurantPicture->setRestaurant($restaurant);
                $restaurantPicture->setFilename('https://picsum.photos/640/480?random=' . $faker->unique()->numberBetween(1, 10000)); // Générer une URL d'image

                $manager->persist($restaurantPicture);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            RestaurantFixtures::class,
        );
    }
}
