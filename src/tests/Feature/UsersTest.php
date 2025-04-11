<?php

it('create and update user', function (){

    $timestamp = now();
    $randomEmail = 'deleteuser' . $timestamp->format('YmdHis') . '@example.com';
    
    $createResponse = $this->post('/users', [
        'name' => 'user to delete',
        'email' => $randomEmail,
        'password' => 'deletepassword',
    ]);
    
    $createResponse->assertStatus(201);
    
    $userId = $createResponse->json('user.id');
    
    $response = $this->delete("/users/{$userId}");

    $response->assertStatus(204);
});