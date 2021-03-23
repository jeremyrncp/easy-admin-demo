<?php


namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testShouldHaveThreeProduct()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/');

        $this->assertCount(3, $crawler->filter('.card'));
    }
}