<?php

namespace App\Tests\Controller;

use App\Entity\Cordonnes;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class CordonnesControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/cordonnes/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Cordonnes::class);

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
        self::assertPageTitleContains('Cordonne index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'cordonne[civilite]' => 'Testing',
            'cordonne[prenom_nom]' => 'Testing',
            'cordonne[email]' => 'Testing',
            'cordonne[tele_mobile]' => 'Testing',
            'cordonne[tele_fixe]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Cordonnes();
        $fixture->setCivilite('My Title');
        $fixture->setPrenom_nom('My Title');
        $fixture->setEmail('My Title');
        $fixture->setTele_mobile('My Title');
        $fixture->setTele_fixe('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Cordonne');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Cordonnes();
        $fixture->setCivilite('Value');
        $fixture->setPrenom_nom('Value');
        $fixture->setEmail('Value');
        $fixture->setTele_mobile('Value');
        $fixture->setTele_fixe('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'cordonne[civilite]' => 'Something New',
            'cordonne[prenom_nom]' => 'Something New',
            'cordonne[email]' => 'Something New',
            'cordonne[tele_mobile]' => 'Something New',
            'cordonne[tele_fixe]' => 'Something New',
        ]);

        self::assertResponseRedirects('/cordonnes/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getCivilite());
        self::assertSame('Something New', $fixture[0]->getPrenom_nom());
        self::assertSame('Something New', $fixture[0]->getEmail());
        self::assertSame('Something New', $fixture[0]->getTele_mobile());
        self::assertSame('Something New', $fixture[0]->getTele_fixe());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Cordonnes();
        $fixture->setCivilite('Value');
        $fixture->setPrenom_nom('Value');
        $fixture->setEmail('Value');
        $fixture->setTele_mobile('Value');
        $fixture->setTele_fixe('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/cordonnes/');
        self::assertSame(0, $this->repository->count([]));
    }
}
