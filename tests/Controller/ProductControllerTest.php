<?php

namespace Tests\Controller;

use App\Entity\Product;
use Doctrine\Common\DataFixtures\ProxyReferenceRepository;
use Doctrine\Common\DataFixtures\ReferenceRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    /** @var \Symfony\Bundle\FrameworkBundle\KernelBrowser|null */
    private $client = null;

    /**
     * @var object
     */
    private $testProduct;

    public function setUp(): void
    {
        $this->client = self::createClient();
        $manager = $this->client->getKernel()->getContainer()->get('doctrine')->getManager();
        $this->testProduct = $manager
            ->getRepository(Product::class)
            ->findOneBy(['name' => 'Test name']);
    }

    public function testListAction(): void
    {
        $this->client->request('GET', '/products/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertTrue(count(json_decode($this->client->getResponse()->getContent(), true)) > 0);
    }

    public function testGetSingleAction(): void
    {
        $this->client->request('GET', sprintf('/product/%s', $this->testProduct->getId()));
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        self::assertStringContainsString('Test name', json_decode($this->client->getResponse()->getContent(), true));

        $this->client->request('GET', sprintf('/product/%s', Uuid::uuid4()));
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    }

    public function testCreateAction(): void
    {
        $this->client->request('POST', '/products/add', [
            'name' => 'Test',
            'description' => 'test',
            'ptu' => 'test'
        ]);

        self::assertEquals(200, $this->client->getResponse()->getStatusCode());
        self::assertStringContainsString('ok', $this->client->getResponse()->getContent());

        $this->client->request('POST', '/products/add');
        self::assertEquals(200, $this->client->getResponse()->getStatusCode());
        self::assertStringContainsString('not found', $this->client->getResponse()->getContent());
    }

    public function testUpdateAction(): void
    {
        $this->client->request('POST',  sprintf('/products/update/%s', $this->testProduct->getId()), [
            'name' => 'Zmieniono: test',
            'description' => 'test',
            'ptu' => 'test'
        ]);

        self::assertEquals(200, $this->client->getResponse()->getStatusCode());
        self::assertStringContainsString('ok', $this->client->getResponse()->getContent());

        $this->client->request('GET', sprintf('/product/%s', $this->testProduct->getId()));
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        self::assertStringContainsString('Zmieniono: test', json_decode($this->client->getResponse()->getContent(), true));

        $this->client->request('POST',  sprintf('/products/update/%s', Uuid::uuid4()), [
            'name' => 'Zmieniono: test',
            'description' => 'test',
            'ptu' => 'test'
        ]);

        $this->client->request('POST', '/products/add');
        self::assertEquals(200, $this->client->getResponse()->getStatusCode());
        self::assertStringContainsString('not found', $this->client->getResponse()->getContent());
    }
}