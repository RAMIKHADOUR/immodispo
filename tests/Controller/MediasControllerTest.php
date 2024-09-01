<?php

namespace App\Tests\Controller;

use App\Entity\Medias;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class MediasControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/medias/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Medias::class);

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
        self::assertPageTitleContains('Media index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'media[type_media]' => 'Testing',
            'media[file_path]' => 'Testing',
            'media[annonces]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Medias();
        $fixture->setType_media('My Title');
        $fixture->setFile_path('My Title');
        $fixture->setAnnonces('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Media');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Medias();
        $fixture->setType_media('Value');
        $fixture->setFile_path('Value');
        $fixture->setAnnonces('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'media[type_media]' => 'Something New',
            'media[file_path]' => 'Something New',
            'media[annonces]' => 'Something New',
        ]);

        self::assertResponseRedirects('/medias/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getType_media());
        self::assertSame('Something New', $fixture[0]->getFile_path());
        self::assertSame('Something New', $fixture[0]->getAnnonces());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Medias();
        $fixture->setType_media('Value');
        $fixture->setFile_path('Value');
        $fixture->setAnnonces('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/medias/');
        self::assertSame(0, $this->repository->count([]));
    }
}
