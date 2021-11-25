<?php

namespace Tests\Feature;

use Tests\TestCase;
use GuzzleHttp\Client;

class UserCanLoginTest extends TestCase {

    /** @test */
    public function a_user_can_login() {
        /*
         * Mas que un test, este es el metodo por el 
         * cual obtendras el token con el cual realizarás
         * el test real cuando requiera autenticación.
         * Pon la url de tu proyecto en la variable publica
         * 'base_uri' en el archivo TestCase.php, Esta
         * puede variar dependiendo si trabajas con xampp
         * o artisan serve.
         */
        $client = new Client(['base_uri' => $this->base_uri]);
        $response = $client->post('login', [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'json' => [
                'email' => 'superuser@hotmail.com',
                'password' => '123' //'123' es la clave
            ]
        ]);
        $toJson = json_decode($response->getBody());
        if ($toJson->status == 200) {
            \Log::debug($toJson->data->token);
            /*
             * El token fue impreso en storage/logs/laravel.log, copialo y
             * pegalo en la variable publica 'token' en el archivo TestCase.php
             */
        } else {
            \Log::debug('Credenciales invalidas');
        }
    }

}
