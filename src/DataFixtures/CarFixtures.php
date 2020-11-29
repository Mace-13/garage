<?php

namespace App\DataFixtures;

use App\Entity\Car;
use App\Entity\Image;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CarFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('FR-fr');


        for($c=0; $c<=9; $c++){

            $car = new Car();
            $slugify = new Slugify();

            $marque = $faker->lexify('Car ???');
            $modele = $faker->lexify('?????');
            $slug = $slugify->slugify($marque.'-'.$modele.'-'.rand(1,100));
            $description = $faker->paragraph(2);
            $carOption = '<p>'.join('</p><p>',$faker->sentences(5)).'</p>';
            $date = $faker->dateTime($max = 'now', $timezone = null);
            $carburant = ['essence','diesel','hybride','electrique'];
            $transmission = ['manuelle','automatique'];

            $car->setMarque($marque)
                ->setModele($modele)
                ->setSlug($slug)
                ->setKm(rand(0,50000))
                ->setPrix(rand(50000,300000))
                ->setOwner(rand(0,4))
                ->setCylindre(rand(80,400))
                ->setPuissance(rand(100,1000))
                ->setCarburant($faker->randomElement($carburant))
                ->setMiseCirculation($date)
                ->setTransmission($faker->randomElement($transmission))
                ->setDescription($description)
                ->setCarOption($carOption)
                ->setCoverImage('https://picsum.photos/1000/350')
            ;

            $manager->persist($car);

            for($i=1; $i <= rand(2,5); $i++){
                $image = new Image();
                $image->setUrl('https://picsum.photos/200/200')
                    ->setCaption($faker->sentence())
                    ->setCar($car);
                $manager->persist($image);
            }
        }

        $manager->flush();
    }
}
