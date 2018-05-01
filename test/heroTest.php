<?php
declare(strict_types=1);
require("vendor\autoload.php");
include("api/objects/hero.php");

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

final class HeroTest extends TestCase
{
    protected $client;
    static $hero;

    protected function setup()
    {
        $this->client = new Client([
            "base_uri" => "http://localhost"
        ]);

        // create hero
        if (!isset(self::$hero)) {
            self::$hero = new Hero(null);
            self::$hero->setUsername("heroTesto" . mt_rand());
            self::$hero->setFirstname("test");
            self::$hero->setLastname("person");
            self::$hero->setGender(1);
        }
        
    }

    public function testCanCreateHero()
    {
        $response = $this->client->request('POST', '/phpheroes/api/hero/create.php', [
            'form_params' => [
                "username" => self::$hero->getUsername(),
                "firstname" => self::$hero->getFirstname(),
                "lastname" => self::$hero->getLastname(),
                "gender" => self::$hero->getGender()
            ],
            'http_errors' => false
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $body = (string) $response->getBody();
        $data = json_decode($body, true);
        $this->assertArrayHasKey('id', $data);       
        self::$hero->setId(intval($data['id'])); 
    }

    public function testCanGetHeroById()
    {
        $response = $this->client->request('GET', "/phpheroes/api/hero/read.php?id=" . self::$hero->getId(), ['http_errors' => false]);
        $this->assertEquals(200, $response->getStatusCode());

        $body = (string) $response->getBody();
        $data = json_decode($body, true);
        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('username', $data);
        $this->assertArrayHasKey('firstname', $data);
        $this->assertArrayHasKey('lastname', $data); 
    }

    public function testCanUpdateHeroById()
    {
        $response = $this->client->request('POST', '/phpheroes/api/hero/update.php', [
            'form_params' => [
                "id" => self::$hero->getId(),
                "username" => self::$hero->getUsername(),
                "firstname" => self::$hero->getFirstname(),
                "lastname" => self::$hero->getLastname(),
                "gender" => self::$hero->getGender()
            ],
            'http_errors' => false
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCanDeleteHeroById()
    {
        $response = $this->client->request('POST', '/phpheroes/api/hero/delete.php', [
            'form_params' => [
                "id" => self::$hero->getId()
            ],
            'http_errors' => false
        ]);

        $body = (string) $response->getBody();
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCanGetAllHeroes()
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