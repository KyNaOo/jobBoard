<?php

namespace App\Test\Controller;

use App\Entity\Advertisement;
use App\Repository\AdvertisementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdvertisementControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private AdvertisementRepository $repository;
    private string $path = '/advertisement/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Advertisement::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Advertisement index');

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
            'advertisement[title]' => 'Testing',
            'advertisement[description]' => 'Testing',
            'advertisement[location]' => 'Testing',
            'advertisement[adress]' => 'Testing',
            'advertisement[resume]' => 'Testing',
            'advertisement[wages]' => 'Testing',
            'advertisement[companyId]' => 'Testing',
        ]);

        self::assertResponseRedirects('/advertisement/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Advertisement();
        $fixture->setTitle('My Title');
        $fixture->setDescription('My Title');
        $fixture->setLocation('My Title');
        $fixture->setAdress('My Title');
        $fixture->setResume('My Title');
        $fixture->setWages('My Title');
        $fixture->setCompanyId('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Advertisement');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Advertisement();
        $fixture->setTitle('My Title');
        $fixture->setDescription('My Title');
        $fixture->setLocation('My Title');
        $fixture->setAdress('My Title');
        $fixture->setResume('My Title');
        $fixture->setWages('My Title');
        $fixture->setCompanyId('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'advertisement[title]' => 'Something New',
            'advertisement[description]' => 'Something New',
            'advertisement[location]' => 'Something New',
            'advertisement[adress]' => 'Something New',
            'advertisement[resume]' => 'Something New',
            'advertisement[wages]' => 'Something New',
            'advertisement[companyId]' => 'Something New',
        ]);

        self::assertResponseRedirects('/advertisement/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitle());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getLocation());
        self::assertSame('Something New', $fixture[0]->getAdress());
        self::assertSame('Something New', $fixture[0]->getResume());
        self::assertSame('Something New', $fixture[0]->getWages());
        self::assertSame('Something New', $fixture[0]->getCompanyId());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Advertisement();
        $fixture->setTitle('My Title');
        $fixture->setDescription('My Title');
        $fixture->setLocation('My Title');
        $fixture->setAdress('My Title');
        $fixture->setResume('My Title');
        $fixture->setWages('My Title');
        $fixture->setCompanyId('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/advertisement/');
    }
}
