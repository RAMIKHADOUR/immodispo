<?php

namespace App\Tests\Controller;

use App\Entity\Adresses;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class AdressesControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/adresses/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Adresses::class);

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
        self::assertPageTitleContains('Adress index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'adress[no_voie]' => 'Testing',
            'adress[type_voie]' => 'Testing',
            'adress[voie]' => 'Testing',
            'adress[ville]' => 'Testing',
            'adress[code_postale]' => 'Testing',
            'adress[region]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Adresses();
        $fixture->setNo_voie('My Title');
        $fixture->setType_voie('My Title');
        $fixture->setVoie('My Title');
        $fixture->setVille('My Title');
        $fixture->setCode_postale('My Title');
        $fixture->setRegion('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Adress');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Adresses();
        $fixture->setNo_voie('Value');
        $fixture->setType_voie('Value');
        $fixture->setVoie('Value');
        $fixture->setVille('Value');
        $fixture->setCode_postale('Value');
        $fixture->setRegion('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'adress[no_voie]' => 'Something New',
            'adress[type_voie]' => 'Something New',
            'adress[voie]' => 'Something New',
            'adress[ville]' => 'Something New',
            'adress[code_postale]' => 'Something New',
            'adress[region]' => 'Something New',
        ]);

        self::assertResponseRedirects('/adresses/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNo_voie());
        self::assertSame('Something New', $fixture[0]->getType_voie());
        self::assertSame('Something New', $fixture[0]->getVoie());
        self::assertSame('Something New', $fixture[0]->getVille());
        self::assertSame('Something New', $fixture[0]->getCode_postale());
        self::assertSame('Something New', $fixture[0]->getRegion());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Adresses();
        $fixture->setNo_voie('Value');
        $fixture->setType_voie('Value');
        $fixture->setVoie('Value');
        $fixture->setVille('Value');
        $fixture->setCode_postale('Value');
        $fixture->setRegion('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/adresses/');
        self::assertSame(0, $this->repository->count([]));
    }
}
