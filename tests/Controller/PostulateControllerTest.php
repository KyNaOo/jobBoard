<?php

namespace App\Test\Controller;

use App\Entity\Postulate;
use App\Repository\PostulateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostulateControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private PostulateRepository $repository;
    private string $path = '/postulate/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Postulate::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Postulate index');

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
            'postulate[emailSent]' => 'Testing',
            'postulate[date]' => 'Testing',
            'postulate[userId]' => 'Testing',
            'postulate[advertisementId]' => 'Testing',
        ]);

        self::assertResponseRedirects('/postulate/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Postulate();
        $fixture->setEmailSent('My Title');
        $fixture->setDate('My Title');
        $fixture->setUserId('My Title');
        $fixture->setAdvertisementId('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Postulate');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Postulate();
        $fixture->setEmailSent('My Title');
        $fixture->setDate('My Title');
        $fixture->setUserId('My Title');
        $fixture->setAdvertisementId('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'postulate[emailSent]' => 'Something New',
            'postulate[date]' => 'Something New',
            'postulate[userId]' => 'Something New',
            'postulate[advertisementId]' => 'Something New',
        ]);

        self::assertResponseRedirects('/postulate/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getEmailSent());
        self::assertSame('Something New', $fixture[0]->getDate());
        self::assertSame('Something New', $fixture[0]->getUserId());
        self::assertSame('Something New', $fixture[0]->getAdvertisementId());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Postulate();
        $fixture->setEmailSent('My Title');
        $fixture->setDate('My Title');
        $fixture->setUserId('My Title');
        $fixture->setAdvertisementId('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/postulate/');
    }
}
