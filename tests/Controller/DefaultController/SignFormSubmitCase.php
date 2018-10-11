<?php

namespace App\Tests\Controller\DefaultController;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

abstract class SignFormSubmitCase extends WebTestCase {

    /** @var Client */
    protected $client;

    protected $redirectUri;
    protected $errorMessage;

    public function setUp() {
        $this->client = self::createClient();
    }

    protected function submitSignForm(Crawler $crawler) {
        $form = $crawler->filter('.btn-default')->form();
        $data = $this->fillFormData();

        $crawler = $this->client->submit($form, $data);

        if ($this->client->getResponse()->isRedirection()) {
            return $this->client->followRedirect();
        }

        return $crawler;
    }

    protected function assertSuccessFormSubmit(Crawler $crawler) {
        $this->submitSignForm($crawler);

        $this->assertTrue($this->client->getResponse()->isRedirection());
        $this->assertContains($this->redirectUri, $this->client->getHistory()->current()->getUri());
    }

    protected function assertWrongFormSubmit(Crawler $crawler) {
        $crawler = $this->submitSignForm($crawler);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains($this->redirectUri, $this->client->getHistory()->current()->getUri());

        return $crawler;
    }

    protected function assertWrongFormSubmitWithErrorMessage(Crawler $crawler, $filter) {
        $crawler = $this->assertWrongFormSubmit($crawler);
        $this->assertContains($this->errorMessage, $crawler->filter($filter)->text());
    }

    protected abstract function fillFormData();
}