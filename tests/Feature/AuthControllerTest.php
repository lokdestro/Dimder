<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_loads_signin_page()
    {
        $response = $this->get('/signin');
        $response->assertStatus(200);
    }

    /** @test */
    public function it_loads_signup_page()
    {
        $response = $this->get('/signup');
        $response->assertStatus(200);
    }

    /** @test */
    public function it_loads_logout_page()
    {
        $response = $this->get('/weblogout');
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_register_a_user()
    {
        $data = [
            'name' => 'John',
            'surname' => 'Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password'
        ];

        $response = $this->post('/register', $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('users', ['email' => 'johndoe@example.com']);
    }

    /** @test */
    public function it_fails_to_register_an_existing_user()
    {
        $existingUser = User::create([
            'name' => 'Jane',
            'email' => 'janedoe@example.com',
            'password' => bcrypt('password')
        ]);

        $data = [
            'name' => 'John',
            'surname' => 'Doe',
            'email' => $existingUser->email,
            'password' => 'password'
        ];

        $response = $this->post('/register', $data);
        $response->assertStatus(200);
        $this->assertEquals('Error', $response->json('message'));
    }

    /** @test */
    public function it_can_login_a_user()
    {
        $user = User::create([
            'name' => 'John',
            'email' => 'johndoe@example.com',
            'password' => bcrypt('password')
        ]);

        $data = [
            'email' => 'johndoe@example.com',
            'password' => 'password'
        ];

        $response = $this->post('/login', $data);
        $response->assertStatus(200);
        $response->assertJsonStructure(['status', 'user', 'token']);
    }

    /** @test */
    public function it_fails_to_login_with_invalid_credentials()
    {
        $data = [
            'email' => 'nonexistent@example.com',
            'password' => 'wrongpassword'
        ];

        $response = $this->post('/login', $data);
        $response->assertStatus(401);
        $response->assertJson(['message' => 'Unauthorized']);
    }

    /** @test */
    /** @test */
public function it_can_logout_a_user()
{
    $user = User::create([
        'name' => 'John',
        'email' => 'johndoe@example.com',
        'password' => bcrypt('password')
    ]);

    $this->actingAs($user); // Логиним пользователя

    $response = $this->post('/logout'); // Используем POST метод
    $response->assertStatus(200);
    $response->assertJson(['message' => 'Successfully logged out']);
}


    /** @test */
    public function it_can_get_user_data()
    {
        $user = User::create([
            'name' => 'John',
            'email' => 'johndoe@example.com',
            'password' => bcrypt('password')
        ]);

        $this->actingAs($user); // Логиним пользователя

        $response = $this->get('/getData');
        $response->assertStatus(200);
        $response->assertJsonStructure(['users', 'status']);
        $this->assertCount(1, $response->json('users'));
    }
}
