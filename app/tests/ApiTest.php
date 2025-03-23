<?php
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class ApiTest extends TestCase{

    private $client;
    private $baseUrl = 'http://localhost:8888'; // Replace with your API's base URL

    protected function setUp(): void
    {
        $this->client = new Client(['base_uri' => $this->baseUrl]);
    }
   
    public function testGetUserDetails()
    {
        $response = $this->client->get('/api/users/getUserDetails/neo'); 

        $this->assertEquals(200, $response->getStatusCode());
        $contentType = $response->getHeaderLine('Content-Type');
        $this->assertStringContainsString('application/json', $contentType);

        $body = json_decode($response->getBody(), true);
        $this->assertIsArray($body);
        $this->assertArrayHasKey('username', $body);
        $this->assertEquals('neo', $body['username']); 
    }

    public function testCreateUserInvalidData()
    {
        $userData = [
            'username' => '', // Invalid data
            
        ];

        $response = $this->client->post('/api/users/add', [
            'json' => $userData,
        ]);
        
        $this->assertEquals(422, $response->getStatusCode()); 
        $contentType = $response->getHeaderLine('Content-Type');
        $this->assertStringContainsString('application/json', $contentType);

        $body = json_decode($response->getBody(), true);
        $this->assertIsArray($body);
        $this->assertArrayHasKey('errors', $body);
    }

    public function testPostMessage()
    {
        

        $messageData = [
            'group_id' => 1, 
            'user_id' => 1,
            'message' => 'hire me'
            
        ];

        $response = $this->client->post('/api/groups/messages/add', [
            'json' => $messageData,
        ]);

        $this->assertEquals(201, $response->getStatusCode());
        $contentType = $response->getHeaderLine('Content-Type');
        $this->assertStringContainsString('application/json', $contentType);

       
    }

    public function testGetMessages()
    {

        $groupdata = [
            'group_id' => 1
            
            
        ];
        $response = $this->client->get('/api/groups/messages/get',[
            'json' => $groupdata
        ]); 

        $this->assertEquals(200, $response->getStatusCode());
        $contentType = $response->getHeaderLine('Content-Type');
        $this->assertStringContainsString('application/json', $contentType);

       
    }

}