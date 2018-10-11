<?php

namespace App\Tests\Controller\RegisterController;

use App\Tests\Controller\RegisterTestCase;
use Doctrine\ORM\EntityManagerInterface;

class SuccessRegisterTest extends RegisterTestCase {

    const REDIRECT_URI = '/admin';

    const USERNAME = 'maria';
    const EMAIL = 'maria@mail.com';
    const PASSWORD = 'maria';

    public function setUp() {
        parent::setUp();

        $this->redirectUri = self::REDIRECT_URI;

        $this->username = self::USERNAME;
        $this->email = self::EMAIL;
        $this->password = self::PASSWORD;
    }

    public function testSuccessRegister() {
        $crawler = $this->client->request(self::METHOD, self::URI);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertSuccessFormSubmit($crawler);
    }

    public function tearDown() {
        $container = $this->client->getContainer();
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $container->get('doctrine.orm.entity_manager');

        $registeredUser = $entityManager->getRepository('App:User')->findOneBy(['email' => self::EMAIL]);
        $entityManager->remove($registeredUser);
        $entityManager->flush();
    }
}