<?php

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'admin@esport.com',
        'password' => 'admin123',
        'password_confirmation' => 'admin123',
        'accept_privacy' => true,
        'accept_terms' => true,
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('admin.dashboard', absolute: false));
});
