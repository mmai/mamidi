<?php

namespace Mamidi\ClassifiedBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReservationControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
    }

    public function testAccept()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/accept');
    }

    public function testReject()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/reject');
    }

}
