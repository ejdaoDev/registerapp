<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use GuzzleHttp\Client;

class CanDeleteUserTest extends TestCase {

    public function test_a_user_can_be_deleted() {
        $id = 32; //asegurate que el usuario exista en la base de datos
        $client = new Client(['base_uri' => $this->base_uri]);
        $response = $client->delete('user/' . $id, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'bearer ' . $this->token
            ]
        ]);
        $toJson = json_decode($response->getBody());
        if ($toJson->status == 200) {
            \Log::debug($toJson->data->message);
            $this->assertCount(0, User::all()->where('id', $id));
        }
    }

}
