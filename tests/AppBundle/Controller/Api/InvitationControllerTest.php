<?php

namespace Tests\AppBundle\Controller\Api;

use AppBundle\Controller\Api\InvitationController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// We could extend \PHPUnit_Framework_TestCase and use Guzzle too

/**
 * Class InvitationControllerTest
 * @package Tests\AppBundle\Controller\Api
 */
class InvitationControllerTest extends WebTestCase
{
    private $inviteId;

    public function loggedinClient()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('_submit')->form(array(
            '_username' => 'testUser',
            '_password' => '123456',
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();
        return $client;
    }
    public function test_it_should_generate_401_when_user_is_not_loggedin_on_create_an_invitation()
    {
        $client = static::createClient();

        // submits a raw JSON string in the request body
        $client->request(
            'POST',
            '/api/v1/invitations',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"invitedUsername":"Bob"}'
        );

        $this->assertEquals(
            401,
            $client->getResponse()->getStatusCode()
        );
    }

    public function test_it_should_create_an_invitation_successfully()
    {
        $client = $this->loggedinClient();

        // submits a raw JSON string in the request body
        $client->request(
            'POST',
            '/api/v1/invitations',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"invitedUsername":"Bob"}'
        );


            $this->assertEquals(
            201,
            $client->getResponse()->getStatusCode()
        );
        $this->assertJson($client->getResponse()->getContent());
        $this->assertContains('id', $client->getResponse()->getContent());

    }

    public function test_validator_should_generate_400_response_when_invitedUsername_is_empty_on_create_an_invitation()
    {
        $client = $this->loggedinClient();

        // submits a raw JSON string in the request body
        $client->request(
            'POST',
            '/api/v1/invitations',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"invitedUsername":""}'
        );

        $this->assertEquals(
            400,
            $client->getResponse()->getStatusCode()
        );
    }

}