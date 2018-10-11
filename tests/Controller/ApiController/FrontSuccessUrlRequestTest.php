<?php

namespace App\Tests\Controller\ApiController;

use App\Entity\ShortLink;
use App\Tests\Utils\UserGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Id\AssignedGenerator;
use Doctrine\ORM\Mapping\ClassMetadata;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FrontSuccessUrlRequestTest extends WebTestCase {

    const URI = '/api/shortlink/';
    const METHOD = 'GET';

    const SHORT_LINK_ID = 1;
    const SHORT_LINK_VALUE = 'b';
    const SHORT_LINK_URL = 'http://youtube.com';

    /** @var Client */
    private $client;

    /** @var EntityManagerInterface $entityManager */
    private $em;

    /** @var ShortLink */
    private $shortLink;

    public function setUp() {
        $this->client = self::createClient();

        $this->setUpEntityManager();
        $this->createShortLink();
    }

    private function setUpEntityManager() {
        $container = $this->client->getContainer();
        $this->em = $container->get('doctrine.orm.entity_manager');
    }

    private function createShortLink() {
        $this->shortLink = new ShortLink();

        $this->setManualShortLinkId();
        $this->shortLink->setUrl(self::SHORT_LINK_URL);
        $this->shortLink->setUser($this->createUser());

        $this->em->persist($this->shortLink);
        $this->em->flush();
    }

    private function setManualShortLinkId() {
        $shortLinkMetadata = $this->em->getClassMetadata(ShortLink::class);
        $shortLinkMetadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
        $shortLinkMetadata->setIdGenerator(new AssignedGenerator());

        $this->shortLink->setId(self::SHORT_LINK_ID);
    }

    private function createUser() {
        $container = $this->client->getContainer();
        $userGenerator = $container->get(UserGenerator::class);

        return $userGenerator->createTestUser();
    }

    public function testSuccessUrlRequest() {
        $this->client->request(self::METHOD, self::URI.self::SHORT_LINK_VALUE);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertResponseUrl();
    }

    private function assertResponseUrl() {
        $content = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(self::SHORT_LINK_URL, $content['url']);
    }

    public function tearDown() {
        $stats = $this->em->getRepository('App:LinkRequestStats')->findAll();

        foreach ($stats as $stat) {
            $this->em->remove($stat);
        }

        $this->em->remove($this->shortLink);
        $this->em->flush();
    }
}