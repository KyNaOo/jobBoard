<?php

namespace App\DataFixtures;

use App\Entity\Company;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;
class CompanyFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        require_once 'vendor/autoload.php';
        $faker = Faker\Factory::create('fr_FR');
        $domains = [
            'informatique'=>'1',
            'télécomunication'=>'2',
            'gastronomie'=>'3',
            'maintenance'=>'4',
            'batiment'=>'5',
            'transports en commun'=>'6',
        ];
        for($i=0;$i<20;$i++){
            $company = new Company;
            $company->setName($faker->company)
                    ->setLocation($faker->city)
                    ->setNbEmployees(random_int(5,3000))
                    ->setRevenues(random_int(10000,100000000).'€')
                    ->setCreationDate($faker->dateTimeBetween('-100 years', '-2 years'))
                    ->setDomain(array_rand($domains, 1));
            $manager->persist($company);
        }
        $manager->flush();
    }
    public function getOrder(): int{
        return 1;
    }
}
