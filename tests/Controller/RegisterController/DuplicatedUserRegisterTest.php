<?php

namespace App\Tests\Controller\RegisterController;

use App\Tests\Controller\RegisterTestCase;
use App\Tests\Utils\UserGenerator;
use Doctrine\ORM\EntityManagerInterface;

class DuplicatedUserRegisterTest extends RegisterTestCase {

    const REDIRECT_URI = '/register';

    const USERNAME = UserGenerator::USERNAME;
    const EMAIL = UserGenerator::EMAIL;
    const PASSWORD = UserGenerator::PASSWORD;

    const DUPLICATED_USERNAME_ERROR_MESSAGE = 'Username is already used';
    const DUPLICATED_EMAIL_ERROR_MESSAGE = 'Email is already used';

    /** @var EntityManagerInterface */
    private $em;

    public function setUp() {
        parent::setUp();

        $this->setUpEntityManager();
        $this->createUser();

        $this->redirectUri = self::REDIRECT_URI;

        $this->username = self::USERNAME;
        $this->email = self::EMAIL;
        $this->password = self::PASSWORD;
    }

    private function setUpEntityManager() {
        $container = $this->client->getContainer();
        $this->em = $container->get('doctrine.orm.entity_manager');
    }

    private function createUser() {
        $container = $this->client->getContainer();
        $userGenerator = $container->get(UserGenerator::class);
        $this->user = $userGenerator->createTestUser();

        $this->em->persist($this->user);
        $this->em->flush();
    }

    public function testDuplicatedUsernameRegister() {
        $this->errorMessage = self::DUPLICATED_USERNAME_ERROR_MESSAGE;

        $crawler = $this->client->request(self::METHOD, self::URI);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertWrongFormSubmitWithErrorMessage($crawler, '.inner>div');
    }

    public function testDuplicatedEmailRegister() {
        $this->errorMessage = self::DUPLICATED_EMAIL_ERROR_MESSAGE;
        $this->username = 'nuevo';

        $crawler = $this->client->request(self::METHOD, self::URI);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertWrongFormSubmitWithErrorMessage($crawler, '.inner>div');
    }

    public function tearDown() {
        // el objeto se ha serializado y su estado ha pasado a detached, necesario hacer merge para poder eliminarlo
        $this->user = $this->em->merge($this->user);

        $this->em->remove($this->user);
        $this->em->flush();
    }
}