<?php

namespace App\Tests\Controller\ApiController;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class FrontUrlRequestTestCase extends WebTestCase {

    const URI = '/api/shortlink/';
    const METHOD = 'POST';

    /** @var Client */
    protected $client;
}