<?php

use Tests\TestCase;

uses(TestCase::class);

test('get users', function () {
    $response = $this->get('/users');

    $response->assertStatus(200);
    $response->assertJsonStructure(['data' => ['*' => ['id', 'name', 'email', 'email_verified_at', 'created_at', 'updated_at']]]);
});

test('get user with search: admin', function () {
    $response = $this->get('/users?search=admin');

    $response->assertStatus(200);
    $response->assertJsonStructure(['data' => ['*' => ['id', 'name', 'email', 'email_verified_at', 'created_at', 'updated_at']]]);
});

test('get user id: 1', function () {
    $response = $this->get('/users/1');

    $response->assertStatus(200);
    $response->assertJsonStructure(['user' => ['id', 'name', 'email', 'email_verified_at', 'created_at', 'updated_at']]);
});

test('patch user id: 1', function (){

    $response = $this->patch('/users/1', [
        'name' => 'patch Name',
        'email' => 'patch@example.com',
    ]);

    $response->assertStatus(200);
    $response->assertJsonStructure(['user' => ['id', 'name', 'email', 'email_verified_at', 'created_at', 'updated_at']]);
});

test('put user id: 1', function (){

    $response = $this->patch('/users/1', [
        'name' => 'put name',
        'email' => 'put@example.com',
        'password' => 'putnewpassword',
    ]);

    $response->assertStatus(200);
    $response->assertJsonStructure(['user' => ['id', 'name', 'email', 'email_verified_at', 'created_at', 'updated_at']]);
});

test('post user', function (){

    $randomEmail = 'newuser' . rand(1, 1000) . '@example.com';
    
    $response = $this->post('/users', [
        'name' => 'post new user',
        'email' => $randomEmail,
        'password' => 'newpassword',
    ]);

    $response->assertStatus(201);
    $response->assertJsonStructure(['message', 'user' => ['id', 'name', 'email', 'created_at', 'updated_at']]);
});

