<?php
declare(strict_types=1);
require("vendor\autoload.php");
include("api/objects/ability.php");

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

final class AbilityTest extends TestCase
{
    protected $client;
    static $ability;

    protected function setup()
    {
        $this->client = new Client([
            "base_uri" => "http://localhost"
        ]);

        // create ability
        if (!isset(self::$ability)) {
            self::$ability = new Ability(null);
            self::$ability->setName("ability#" . mt_rand());
            self::$ability->setDescription("description for ability");
        }
        
    }

    public function testCanCreateAbility()
    {
        $response = $this->client->request('POST', '/phpheroes/api/ability/create.php', [
            'form_params' => [
                "name" => self::$ability->getName(),
                "description" => self::$ability->getDescription()
            ],
            'http_errors' => false
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $body = (string) $response->getBody();
        $data = json_decode($body, true);
        $this->assertArrayHasKey('id', $data);       
        self::$ability->setId(intval($data['id'])); 
    }

    public function testCanGetAbilityById()
    {
        $response = $this->client->request('GET', "/phpheroes/api/ability/read.php?id=" . self::$ability->getId(), ['http_errors' => false]);
        $this->assertEquals(200, $response->getStatusCode());

        $body = (string) $response->getBody();
        $data = json_decode($body, true);
        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('name', $data);
        $this->assertArrayHasKey('description', $data);
    }

    public function testCanUpdateAbilityById()
    {
        $response = $this->client->request('POST', '/phpheroes/api/ability/update.php', [
            'form_params' => [
                "id" => self::$ability->getId(),
                "name" => self::$ability->getName(),
                "description" => self::$ability->getDescription()
            ],
            'http_errors' => false
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCanDeleteAbilityById()
    {
        $response = $this->client->request('POST', '/phpheroes/api/ability/delete.php', [
            'form_params' => [
                "id" => self::$ability->getId()
            ],
            'http_errors' => false
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCanGetAllAbilities()
    {
        $response = $this->client->request('GET', '/phpheroes/api/ability/read.php', ['http_errors' => false]);


        $this->assertEquals(200, $response->getStatusCode());
        
        $body = (string) $response->getBody();
        $data = json_decode($body, true);
        $first = $data[0];
        
        $this->assertArrayHasKey('id', $first);
        $this->assertArrayHasKey('name', $first);
        $this->assertArrayHasKey('description', $first);
    }
}