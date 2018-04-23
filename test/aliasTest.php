<?php
declare(strict_types=1);
require("vendor\autoload.php");
include("api/objects/alias.php");

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

final class AliasTest extends TestCase
{
    protected $client;
    static $alias;

    protected function setup()
    {
        $this->client = new Client([
            "base_uri" => "http://localhost"
        ]);

        // create alias
        if (!isset(self::$alias)) {
            self::$alias = new Alias(null);
            self::$alias->setName("alias#" . mt_rand());
            self::$alias->setHeroId(1);
        }
        
    }

    public function testCanCreateAlias()
    {
        $response = $this->client->request('POST', '/phpheroes/api/alias/create.php', [
            'form_params' => [
                "name" => self::$alias->getName(),
                "hero_id" => self::$alias->getHeroId()
            ],
            'http_errors' => false
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $body = (string) $response->getBody();
        $data = json_decode($body, true);
        $this->assertArrayHasKey('id', $data);       
        self::$alias->setId(intval($data['id'])); 
    }

    public function testCanGetAliasById()
    {
        $response = $this->client->request('GET', "/phpheroes/api/alias/read.php?id=" . self::$alias->getId(), ['http_errors' => false]);
        $this->assertEquals(200, $response->getStatusCode());

        $body = (string) $response->getBody();
        $data = json_decode($body, true);
        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('name', $data);
        $this->assertArrayHasKey('hero_id', $data);
    }

    public function testCanUpdateAliasById()
    {
        $response = $this->client->request('POST', '/phpheroes/api/alias/update.php', [
            'form_params' => [
                "id" => self::$alias->getId(),
                "name" => self::$alias->getName(),
                "hero_id" => self::$alias->getHeroId()
            ],
            'http_errors' => false
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCanDeleteAliasById()
    {
        $response = $this->client->request('POST', '/phpheroes/api/alias/delete.php', [
            'form_params' => [
                "id" => self::$alias->getId()
            ],
            'http_errors' => false
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCanGetAllAliases()
    {
        $response = $this->client->request('GET', '/phpheroes/api/alias/read.php', ['http_errors' => false]);


        $this->assertEquals(200, $response->getStatusCode());
        
        $body = (string) $response->getBody();
        $data = json_decode($body, true);
        $first = $data[0];
        
        $this->assertArrayHasKey('id', $first);
        $this->assertArrayHasKey('name', $first);
        $this->assertArrayHasKey('hero_id', $first);
    }
}