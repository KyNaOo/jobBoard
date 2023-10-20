<?php

namespace App\DataFixtures;

use App\Entity\Advertisement;
use App\Entity\Company;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Faker;

class AdvertisementFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        $faker = Faker\Factory::create('en_US');
        $jobPositions = array(
            "Software Engineer",
            "Marketing Manager",
            "Data Analyst",
            "Product Owner",
            "Financial Analyst"
        );
        $contracts = [
            'CDD',
            'CDI',
            'Interim',
        ];
        $companyDescription = "Welcome to [Company]! We are a leading company in our industry, dedicated to providing high-quality products/services and exceptional customer experiences. At [Company], we take pride in our commitment to innovation, sustainability, and growth. Our team of professionals is passionate about delivering excellence in everything we do. With a strong focus on teamwork and a culture that values diversity and inclusivity, [Company] is a great place to work and grow. We offer our employees a supportive and collaborative environment where they can thrive and make a real impact. Join us in our mission to continue setting industry standards and making a positive difference in the lives of our customers and the community. Discover the opportunities at [Company] and be a part of our exciting journey toward the future.Now, let's talk about the [JobTitle] position at [Company]. We are currently seeking a talented and motivated [JobTitle] to join our team. As a [JobTitle], you will play a crucial role in our organization. You will work closely with a dynamic team of professionals in a good environment.";
        $companies = $manager->getRepository(Company::class)->getCompanyWithRh();
            foreach($companies as $company){
            $offerer = $manager->getRepository(User::class)->findOneBy(['companyId' => $company]);
            foreach(range(0, random_int(1, 3), 1) as $num){
                $advertisement = new Advertisement;
                shuffle($jobPositions);
                $jobTitle = $jobPositions[0];
                $companyDescription = str_replace("[Company]", $company->getName(), $companyDescription);
                $companyDescription = str_replace("[JobTitle]",$jobTitle, $companyDescription);        
                $advertisement
                ->setTitle($jobTitle)
                ->setDescription($companyDescription)
                ->setWages("3000€")
                ->setWorkingTime('35h/week')
                ->setUserId($offerer)
                ->setCompanyId($company)
                ->setLocation($faker->city)
                ->setAdress($faker->address)
                ->setContract($contracts[0])
                ->setDatePub($faker->dateTimeBetween('-30 days', '-1 day'))
                ;
                shuffle($contracts);
                $companyDescription = str_replace($company->getName(), "[Company]", $companyDescription);
                $companyDescription = str_replace($jobTitle,  "[JobTitle]", $companyDescription);   
                $manager->persist($advertisement);
            }
            ;
        }
        
        

        $manager->flush();
    }

    public function getOrder(): int{
        return 3;
    }
}
