<?php
declare(strict_types=1);
require("vendor\autoload.php");
include("api/objects/hero.php");

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

final class Test extends TestCase
{
    protected $client;
    private $hero;

    protected function setup()
    {
        $this->client = new Client([
            "base_uri" => "http://localhost"
        ]);

        // create hero
        $this->hero = new Hero(null);
        $this->hero->setUsername("heroTesto" . mt_rand());
        $this->hero->setFirstname("test");
        $this->hero->setLastname("person");
        $this->hero->setGender(1);
        $this->hero->setImage("test");
    }
    

    public function testCRUD()
    {
        // Create
        $response = $this->client->request('POST', '/phpheroes/api/hero/create.php', [
            'form_params' => [
                "username" => $this->hero->getUsername(),
                "firstname" => $this->hero->getFirstname(),
                "lastname" => $this->hero->getLastname(),
                "gender" => $this->hero->getGender(),
                "image" => $this->hero->getImage(),
            ],
            'http_errors' => false
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $body = (string) $response->getBody();
        $data = json_decode($body, true);
        $this->assertArrayHasKey('id', $data);       
        $this->hero->setId(intval($data['id'])); 

        // GET
        $response = $this->client->request('GET', "/phpheroes/api/hero/readOne.php?id=" . $this->hero->getId(), ['http_errors' => false]);
        $this->assertEquals(200, $response->getStatusCode());
        
         // Update
        $respnse = $this->client->request('POST', '/phpheroes/api/hero/update.php', [
            'form_params' => [
                "id" => $this->hero->getId(),
                "username" => $this->hero->getUsername(),
                "firstname" => $this->hero->getFirstname(),
                "lastname" => $this->hero->getLastname(),
                "gender" => $this->hero->getGender(),
                "image" => $this->hero->getImage(),
            ],
            'http_errors' => false
        ]);
        $this->assertEquals(200, $response->getStatusCode());

        // Delete
        $response = $this->client->request('POST', '/phpheroes/api/hero/delete.php', [
            'form_params' => [
                "id" => $this->hero->getId()
            ],
            'http_errors' => false
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testLIST()
    {
        $response = $this->client->request('GET', '/phpheroes/api/hero/read.php', ['http_errors' => false]);


        $this->assertEquals(200, $response->getStatusCode());
        
        $body = (string) $response->getBody();
        $data = json_decode($body, true);
        $first = $data[0];
        
        $this->assertArrayHasKey('id', $first);
        $this->assertArrayHasKey('username', $first);
        $this->assertArrayHasKey('firstname', $first);
        $this->assertArrayHasKey('lastname', $first);   
    }
}