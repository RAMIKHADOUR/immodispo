<?php

namespace App\Tests\Controller;

use App\Entity\Descriptions;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class DescriptionsControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/descriptions/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Descriptions::class);

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
        self::assertPageTitleContains('Description index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'description[surface]' => 'Testing',
            'description[chambres]' => 'Testing',
            'description[salle_bains]' => 'Testing',
            'description[etages]' => 'Testing',
            'description[numero_etage]' => 'Testing',
            'description[installId]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Descriptions();
        $fixture->setSurface('My Title');
        $fixture->setChambres('My Title');
        $fixture->setSalle_bains('My Title');
        $fixture->setEtages('My Title');
        $fixture->setNumero_etage('My Title');
        $fixture->setInstallId('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Description');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Descriptions();
        $fixture->setSurface('Value');
        $fixture->setChambres('Value');
        $fixture->setSalle_bains('Value');
        $fixture->setEtages('Value');
        $fixture->setNumero_etage('Value');
        $fixture->setInstallId('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'description[surface]' => 'Something New',
            'description[chambres]' => 'Something New',
            'description[salle_bains]' => 'Something New',
            'description[etages]' => 'Something New',
            'description[numero_etage]' => 'Something New',
            'description[installId]' => 'Something New',
        ]);

        self::assertResponseRedirects('/descriptions/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getSurface());
        self::assertSame('Something New', $fixture[0]->getChambres());
        self::assertSame('Something New', $fixture[0]->getSalle_bains());
        self::assertSame('Something New', $fixture[0]->getEtages());
        self::assertSame('Something New', $fixture[0]->getNumero_etage());
        self::assertSame('Something New', $fixture[0]->getInstallId());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Descriptions();
        $fixture->setSurface('Value');
        $fixture->setChambres('Value');
        $fixture->setSalle_bains('Value');
        $fixture->setEtages('Value');
        $fixture->setNumero_etage('Value');
        $fixture->setInstallId('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/descriptions/');
        self::assertSame(0, $this->repository->count([]));
    }
}
