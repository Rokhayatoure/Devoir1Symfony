<?php

namespace App\DataFixtures;

use App\Entity\Agence as EntityAgence;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class Agence extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
        for ($i = 0; $i < 10; $i++) {
            $agence = new EntityAgence();
            $agence->setNumero("numero".$i);
           $agence->setAdresse("adresse".$i);
           $agence->setTelephone("telephone".$i);

            $manager->persist($agence);
        }

        $manager->flush();
    }
}
