<?php
declare(strict_types=1);
require("vendor\autoload.php");
include("api/objects/team.php");

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

final class TeamTest extends TestCase
{
    protected $client;
    static $team;

    protected function setup()
    {
        $this->client = new Client([
            "base_uri" => "http://localhost"
        ]);

        // create team
        if (!isset(self::$team)) {
            self::$team = new Team(null);
            self::$team->setName("team#" . mt_rand());
            self::$team->setLeaderId(1);
        }
        
    }

    public function testCanCreateTeam()
    {
        $response = $this->client->request('POST', '/phpheroes/api/team/create.php', [
            'form_params' => [
                "name" => self::$team->getName(),
                "leader_id" => self::$team->getLeaderId()
            ],
            'http_errors' => false
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $body = (string) $response->getBody();
        $data = json_decode($body, true);
        
        $this->assertArrayHasKey('id', $data);       
        self::$team->setId(intval($data['id'])); 
    }

    public function testCanGetTeamById()
    {
        $response = $this->client->request('GET', "/phpheroes/api/team/read.php?id=" . self::$team->getId(), ['http_errors' => false]);
        $this->assertEquals(200, $response->getStatusCode());

        $body = (string) $response->getBody();
        $data = json_decode($body, true);
        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('name', $data);
        $this->assertArrayHasKey('leader_id', $data);
    }

    public function testCanUpdateTeamById()
    {
        $response = $this->client->request('POST', '/phpheroes/api/team/update.php', [
            'form_params' => [
                "id" => self::$team->getId(),
                "name" => self::$team->getName(),
                "leader_id" => self::$team->getLeaderId()
            ],
            'http_errors' => false
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCanDeleteTeamById()
    {
        $response = $this->client->request('POST', '/phpheroes/api/team/delete.php', [
            'form_params' => [
                "id" => self::$team->getId()
            ],
            'http_errors' => false
        ]);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCanGetAllTeams()
    {
        $response = $this->client->request('GET', '/phpheroes/api/team/read.php', ['http_errors' => false]);


        $this->assertEquals(200, $response->getStatusCode());
        
        $body = (string) $response->getBody();
        $data = json_decode($body, true);
        $first = $data[0];
        
        $this->assertArrayHasKey('id', $first);
        $this->assertArrayHasKey('name', $first);
        $this->assertArrayHasKey('leader_id', $first);
    }
}