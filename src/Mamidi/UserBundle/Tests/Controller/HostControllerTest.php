<?php

namespace Mamidi\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HostControllerTest extends WebTestCase
{
    public function testMeals()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '{host}/meals');
    }

}
