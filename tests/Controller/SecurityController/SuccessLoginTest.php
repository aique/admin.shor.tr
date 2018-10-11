<?php

namespace App\Tests\Controller\SecurityController;

use App\Entity\User;
use App\Tests\Controller\LoginTestCase;
use App\Tests\Utils\UserGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Tests\Encoder\PasswordEncoder;

class SuccessLoginTest extends LoginTestCase {

    const URI = '/login';
    const REDIRECT_URI = '/admin';
    const METHOD = 'GET';

    /** @var EntityManagerInterface $entityManager */
    private $em;

    /** @var PasswordEncoder */
    private $passwordEncoder;

    /** @var User */
    private $user;

    public function setUp() {
        parent::setUp();

        $this->setUpEntityManager();
        $this->setUpPasswordEncoder();
        $this->createUser();

        $this->username = UserGenerator::USERNAME;
        $this->password = UserGenerator::PASSWORD;

        $this->redirectUri = self::REDIRECT_URI;
    }

    private function setUpEntityManager() {
        $container = $this->client->getContainer();
        $this->em = $container->get('doctrine.orm.entity_manager');
    }

    private function setUpPasswordEncoder() {
        $container = $this->client->getContainer();
        $this->passwordEncoder = $container->get('security.password_encoder');
    }

    private function createUser() {
        $container = $this->client->getContainer();
        $userGenerator = $container->get(UserGenerator::class);
        $this->user = $userGenerator->createTestUser();

        $this->em->persist($this->user);
        $this->em->flush();
    }

    public function testSuccessLogin() {
        $crawler = $this->client->request(self::METHOD, self::URI);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertSuccessFormSubmit($crawler);
    }

    public function tearDown() {
        // el objeto se ha serializado y su estado ha pasado a detached, necesario hacer merge para poder eliminarlo
        $this->user = $this->em->merge($this->user);

        $this->em->remove($this->user);
        $this->em->flush();
    }
}