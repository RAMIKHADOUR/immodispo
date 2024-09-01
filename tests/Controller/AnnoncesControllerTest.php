<?php

namespace App\Tests\Controller;

use App\Entity\Annonces;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class AnnoncesControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/annonces/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Annonces::class);

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
        self::assertPageTitleContains('Annonce index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'annonce[title]' => 'Testing',
            'annonce[createdAt]' => 'Testing',
            'annonce[updatedAt]' => 'Testing',
            'annonce[userId]' => 'Testing',
            'annonce[descriptionId]' => 'Testing',
            'annonce[categoryId]' => 'Testing',
            'annonce[adresseId]' => 'Testing',
            'annonce[typeId]' => 'Testing',
            'annonce[cordId]' => 'Testing',
            'annonce[refId]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Annonces();
        $fixture->setTitle('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setUserId('My Title');
        $fixture->setDescriptionId('My Title');
        $fixture->setCategoryId('My Title');
        $fixture->setAdresseId('My Title');
        $fixture->setTypeId('My Title');
        $fixture->setCordId('My Title');
        $fixture->setRefId('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Annonce');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Annonces();
        $fixture->setTitle('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setUserId('Value');
        $fixture->setDescriptionId('Value');
        $fixture->setCategoryId('Value');
        $fixture->setAdresseId('Value');
        $fixture->setTypeId('Value');
        $fixture->setCordId('Value');
        $fixture->setRefId('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'annonce[title]' => 'Something New',
            'annonce[createdAt]' => 'Something New',
            'annonce[updatedAt]' => 'Something New',
            'annonce[userId]' => 'Something New',
            'annonce[descriptionId]' => 'Something New',
            'annonce[categoryId]' => 'Something New',
            'annonce[adresseId]' => 'Something New',
            'annonce[typeId]' => 'Something New',
            'annonce[cordId]' => 'Something New',
            'annonce[refId]' => 'Something New',
        ]);

        self::assertResponseRedirects('/annonces/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitle());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getUserId());
        self::assertSame('Something New', $fixture[0]->getDescriptionId());
        self::assertSame('Something New', $fixture[0]->getCategoryId());
        self::assertSame('Something New', $fixture[0]->getAdresseId());
        self::assertSame('Something New', $fixture[0]->getTypeId());
        self::assertSame('Something New', $fixture[0]->getCordId());
        self::assertSame('Something New', $fixture[0]->getRefId());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Annonces();
        $fixture->setTitle('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setUserId('Value');
        $fixture->setDescriptionId('Value');
        $fixture->setCategoryId('Value');
        $fixture->setAdresseId('Value');
        $fixture->setTypeId('Value');
        $fixture->setCordId('Value');
        $fixture->setRefId('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/annonces/');
        self::assertSame(0, $this->repository->count([]));
    }
}
