<?php
declare(strict_types=1);
require("vendor\autoload.php");
include("api/objects/relation.php");

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

final class RelationTest extends TestCase
{
    protected $client;
    static $relation;

    protected function setup()
    {
        $this->client = new Client([
            "base_uri" => "http://localhost"
        ]);

        // create relation
        if (!isset(self::$relation)) {
            self::$relation = new Relation(null);
            self::$relation->setHeroId1(2);
            self::$relation->setHeroId2(3);
            self::$relation->setIsFriendly(1);
        }
        
    }

    public function testCanCreateRelation()
    {
        $response = $this->client->request('POST', '/phpheroes/api/relation/create.php', [
            'form_params' => [
                "heroId1" => self::$relation->getHeroId1(),
                "heroId2" => self::$relation->getHeroId2(),
                "isFriendly" => 1
            ],
            'http_errors' => false
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $body = (string) $response->getBody();
        $data = json_decode($body, true);
    }

    public function testCanGetRelationById()
    {
        $response = $this->client->request('GET', "/phpheroes/api/relation/read.php?heroId1=" . self::$relation->getHeroId1() . "&heroId2=" . self::$relation->getHeroId2(), ['http_errors' => false]);
        $this->assertEquals(200, $response->getStatusCode());

        $body = (string) $response->getBody();
        $data = json_decode($body, true);
        $this->assertArrayHasKey('hero_id_1', $data);
        $this->assertArrayHasKey('hero_id_2', $data);
        $this->assertArrayHasKey('is_friendly', $data);
    }

    public function testCanUpdateRelationById()
    {
        $response = $this->client->request('POST', '/phpheroes/api/relation/update.php', [
            'form_params' => [
                "heroId1" => self::$relation->getHeroId1(),
                "heroId2" => self::$relation->getHeroId2(),
                "isFriendly" => 1                
            ],
            'http_errors' => false
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCanDeleteRelationById()
    {
        $response = $this->client->request('POST', '/phpheroes/api/relation/delete.php', [
            'form_params' => [
                "heroId1" => self::$relation->getHeroId1(),
                "heroId2" => self::$relation->getHeroId2()
            ],
            'http_errors' => false
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCanGetAllRelations()
    {
        $response = $this->client->request('GET', '/phpheroes/api/relation/read.php', ['http_errors' => false]);


        $this->assertEquals(200, $response->getStatusCode());
        
        $body = (string) $response->getBody();
        $data = json_decode($body, true);
        $first = $data[0];
        
        $this->assertArrayHasKey('hero_id_1', $first);
        $this->assertArrayHasKey('hero_id_2', $first);
        $this->assertArrayHasKey('is_friendly', $first);
    }
}