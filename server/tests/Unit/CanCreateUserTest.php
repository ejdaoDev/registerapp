<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use GuzzleHttp\Client;

class CanCreateUserTest extends TestCase {

    public function test_a_user_can_be_created() {
        $email = 'user2@hotmail.com';
        $client = new Client(['base_uri' => $this->base_uri]);
        $response = $client->post('user', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'bearer ' . $this->token
            ],
            'json' => [
                'name' => 'user1',
                'email' => $email,
                'role' => 'USER' //puede ser 'ADMIN' o 'USER'
            ]
        ]);
        $toJson = json_decode($response->getBody());
        if ($toJson->status == 204) {
            \Log::debug($toJson->data->message);
            $this->assertCount(0, User::all()->where('email', $email));
        } else {
            \Log::debug($toJson->data->message);
            $this->assertCount(1, User::all()->where('email', $email));
        }
    }

}
