<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements OrderedFixtureInterface
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $passHasher){
        $this->hasher = $passHasher;
    }

    public function load(ObjectManager $manager, ): void
    {
        require_once 'vendor/autoload.php';
        $faker = Faker\Factory::create('fr_FR');
        $l = [];
        $roles = [
            'ROLE_USER',
            'ROLE_RH',
        ];
        $companies = $manager->getRepository(Company::class)->findAll();
        for($i=0;$i<15;$i++){
            $user = new User;
            $user->setGender(random_int(1,3));
            if($user->getGender()===1){
                $user->setFirstName($faker->firstNameMale);
            }else if($user->getGender()===2){
                $user->setFirstName($faker->firstNameFemale);
            } else {
                $user->setFirstName($faker->firstName);
            }
            $user->setLastName($faker->lastName)
                 ->setBirth($faker->dateTimeBetween('-100 years', '-14 years'))
                 ->setCity($faker->city)
                 ->setEmail($faker->email)
                 ->setRoles([$roles[random_int(0,1)]])
                 ->setPassword($this->hasher->hashPassword($user, '123456'))
                 ->setPhone($faker->numerify('0#########'));
            if($user->getRoles()[0]==='ROLE_RH'){
                 $user->setCompanyId($companies[random_int(0, count($companies)-1)]);
            }
            $manager->persist($user);

        }
        $user = new User;
        $user ->setLastName("Bellaiche")
        ->setFirstName("Ethan")
        ->setPassword($this->hasher->hashPassword($user, '123456'))
        ->setPhone("0102030405")
        ->setRoles(["ROLE_ADMIN"])
        ->setCity("Paris")
        ->setGender(1)
        ->setEmail("admin@admin.com")
        ->setBirth($faker->dateTimeBetween('-100 years', '-14 years'))
        ;
        $manager->persist($user);
        $manager->flush();
    }
    public function getOrder(): int{
        return 2;
    }
}
