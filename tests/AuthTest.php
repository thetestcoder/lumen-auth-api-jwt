<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /**
     * register a new user
     *
     * @return void
     */
    public function test_a_user_can_register()
    {
        $res = $this->post('/api/v1/register', [
            'name' => 'The Test Coder',
            'email' => 'thetestcoder@gmail.com',
            'password' => 'password'
        ]);
        $res->assertResponseOk();
    }

    public function test_a_user_can_login()
    {
        $res = $this->post('/api/v1/login', [
            'email' => $this->user->email,
            'password' => 'password'
        ]);
        $res->assertResponseOk();
    }

    public function test_a_user_can_check_own_profile()
    {
        list($res, $jsonResponse) = $this->generateJsonResponse();
        $res = $this->post('/api/v1/me', [], [
            'Authorization' => $jsonResponse->access_token
        ]);
        $res->assertResponseOk();
    }

    public function test_a_user_can_refresh_token()
    {
        list($res, $jsonResponse) = $this->generateJsonResponse();
        $res = $this->post('/api/v1/refresh', [], [
            'Authorization' => $jsonResponse->access_token
        ]);
        $res->assertResponseOk();
    }

    public function test_a_user_can_logout()
    {
        list($res, $jsonResponse) = $this->generateJsonResponse();
        $res = $this->post('/api/v1/logout', [], [
            'Authorization' => $jsonResponse->access_token
        ]);
        $res->assertResponseOk();
    }

    /**
     * @return array
     */
    private function generateJsonResponse(): array
    {
        $res = $this->post('/api/v1/login', [
            'email' => $this->user->email,
            'password' => 'password'
        ]);
        $jsonResponse = json_decode($res->response->baseResponse->content());
        return array($res, $jsonResponse);
    }
}
