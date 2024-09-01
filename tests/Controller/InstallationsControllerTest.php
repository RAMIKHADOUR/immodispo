<?php

namespace App\Tests\Controller;

use App\Entity\Installations;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class InstallationsControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/installations/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Installations::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Installation index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'installation[internet]' => 'Testing',
            'installation[balcon]' => 'Testing',
            'installation[garage]' => 'Testing',
            'installation[gym]' => 'Testing',
            'installation[piscine]' => 'Testing',
            'installation[camera]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Installations();
        $fixture->setInternet('My Title');
        $fixture->setBalcon('My Title');
        $fixture->setGarage('My Title');
        $fixture->setGym('My Title');
        $fixture->setPiscine('My Title');
        $fixture->setCamera('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Installation');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Installations();
        $fixture->setInternet('Value');
        $fixture->setBalcon('Value');
        $fixture->setGarage('Value');
        $fixture->setGym('Value');
        $fixture->setPiscine('Value');
        $fixture->setCamera('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'installation[internet]' => 'Something New',
            'installation[balcon]' => 'Something New',
            'installation[garage]' => 'Something New',
            'installation[gym]' => 'Something New',
            'installation[piscine]' => 'Something New',
            'installation[camera]' => 'Something New',
        ]);

        self::assertResponseRedirects('/installations/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getInternet());
        self::assertSame('Something New', $fixture[0]->getBalcon());
        self::assertSame('Something New', $fixture[0]->getGarage());
        self::assertSame('Something New', $fixture[0]->getGym());
        self::assertSame('Something New', $fixture[0]->getPiscine());
        self::assertSame('Something New', $fixture[0]->getCamera());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Installations();
        $fixture->setInternet('Value');
        $fixture->setBalcon('Value');
        $fixture->setGarage('Value');
        $fixture->setGym('Value');
        $fixture->setPiscine('Value');
        $fixture->setCamera('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/installations/');
        self::assertSame(0, $this->repository->count([]));
    }
}
