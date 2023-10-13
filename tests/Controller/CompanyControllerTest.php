<?php

namespace App\Test\Controller;

use App\Entity\Company;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CompanyControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private CompanyRepository $repository;
    private string $path = '/company/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Company::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Company index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'company[name]' => 'Testing',
            'company[location]' => 'Testing',
            'company[creationDate]' => 'Testing',
            'company[workingTime]' => 'Testing',
            'company[revenues]' => 'Testing',
            'company[nbEmployees]' => 'Testing',
            'company[domain]' => 'Testing',
        ]);

        self::assertResponseRedirects('/company/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Company();
        $fixture->setName('My Title');
        $fixture->setLocation('My Title');
        $fixture->setCreationDate('My Title');
        $fixture->setWorkingTime('My Title');
        $fixture->setRevenues('My Title');
        $fixture->setNbEmployees('My Title');
        $fixture->setDomain('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Company');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Company();
        $fixture->setName('My Title');
        $fixture->setLocation('My Title');
        $fixture->setCreationDate('My Title');
        $fixture->setWorkingTime('My Title');
        $fixture->setRevenues('My Title');
        $fixture->setNbEmployees('My Title');
        $fixture->setDomain('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'company[name]' => 'Something New',
            'company[location]' => 'Something New',
            'company[creationDate]' => 'Something New',
            'company[workingTime]' => 'Something New',
            'company[revenues]' => 'Something New',
            'company[nbEmployees]' => 'Something New',
            'company[domain]' => 'Something New',
        ]);

        self::assertResponseRedirects('/company/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getLocation());
        self::assertSame('Something New', $fixture[0]->getCreationDate());
        self::assertSame('Something New', $fixture[0]->getWorkingTime());
        self::assertSame('Something New', $fixture[0]->getRevenues());
        self::assertSame('Something New', $fixture[0]->getNbEmployees());
        self::assertSame('Something New', $fixture[0]->getDomain());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Company();
        $fixture->setName('My Title');
        $fixture->setLocation('My Title');
        $fixture->setCreationDate('My Title');
        $fixture->setWorkingTime('My Title');
        $fixture->setRevenues('My Title');
        $fixture->setNbEmployees('My Title');
        $fixture->setDomain('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/company/');
    }
}
