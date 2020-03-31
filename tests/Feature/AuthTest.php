<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    // public function setUp(): void
    // {
    //     parent::setUp();
    // }

    /**
     *Test successful registration with good credentials
     */
    public function test_register_with_complete_info()
    {
        $password = $this->faker->password(8, 20);
        $goodUserData = [
            'name' => $this->faker->name,
            'username' => $this->faker->unique()->userName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => $password,
            'password_confirmation' => $password,
        ];
        //try to register
        $response = $this->json('POST', route('api.register'), $goodUserData);
        //Assert that it is successful
        if ($response->status() !== 200) {
            dump($response->getContent());
        }
        $response->assertStatus(200);
        //check for token in the response
        $this->assertArrayHasKey('access_token', $response->json());
    }

    /**
     *Test successful registration with good credentials
     */
    public function test_register_with_username_only()
    {
        $password = $this->faker->password(8, 20);
        $userDataWithoutEmail = [
            'name' => $this->faker->name,
            'username' => $this->faker->unique()->userName,
            'password' => $password,
            'password_confirmation' => $password,
        ];
        //try to register
        $response = $this->json('POST', route('api.register'), $userDataWithoutEmail);
        if ($response->status() !== 200) {
            dump($response->getContent());
        }
        //Assert that it is successful
        $response->assertStatus(200);
        //check for token in the response
        $this->assertArrayHasKey('access_token', $response->json());
    }

    /**
     *Test registration with invalid email
     */
    public function test_register_without_username()
    {
        $password = $this->faker->password(8, 20);
        $badUserData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => $password,
            'password_confirmation' => $password, //same as above
        ];
        //try to register
        $response = $this->json('POST', route('api.register'), $badUserData);
        if ($response->status() !== 422) {
            dump($response->getContent());
        }
        //Assert that it is NOT successful
        $response->assertStatus(422);
    }

    /**
     *Test registration with invalid email
     */
    public function test_register_with_invalid_email()
    {
        $password = $this->faker->password(8, 20);
        $badUserData = [
            'name' => $this->faker->name,
            'username' => $this->faker->unique()->userName,
            'email' => 'notAValidEmail@',
            'password' => $password,
            'password_confirmation' => $password, //same as above
        ];
        //try to register
        $response = $this->json('POST', route('api.register'), $badUserData);
        if ($response->status() !== 422) {
            dump($response->getContent());
        }
        //Assert that it is NOT successful
        $response->assertStatus(422);
    }

    /**
     *Test registration with invalid email
     */
    public function test_register_with_not_matching_password()
    {
        $badUserData = [
            'name' => $this->faker->name,
            'username' => $this->faker->unique()->userName,
            'email' => $this->faker->safeEmail,
            'password' => $this->faker->password(8, 20),
            'password_confirmation' => $this->faker->password(8, 20), //diff from the first one
        ];
        //Send post request
        $response = $this->json('POST', route('api.register'), $badUserData);
        if ($response->status() !== 422) {
            dump($response->getContent());
        }
        //Assert that it is NOT successful, because the password confirmation does not match
        $response->assertStatus(422);
    }


    /**
     *Test successful login
     */
    public function test_login()
    {
        $password = $this->faker->password(8, 20);
        $user = factory(User::class)->create([
            'password' => bcrypt($password)
        ]);
        //Try to log in
        $response = $this->json('POST', route('api.authenticate'), [
            'username' => $user->username,
            'password' => $password,
        ]);
        if ($response->status() !== 200) {
            dump($response->getContent());
        }
        //Assert that it succeeded and received the token
        $response->assertStatus(200);
        $this->assertArrayHasKey('access_token', $response->json());
    }

    /**
     *Test login with wrong username
     */
    public function test_login_with_wrong_username()
    {
        $password = $this->faker->password(8, 20);
        factory(User::class)->create([
            'password' => bcrypt($password)
        ]);

        //try logging in 10 times with wrong password
        for ($i = 0; $i <= 10; $i++) {
            $response = $this->json('POST', route('api.authenticate'), [
                'username' => $this->faker->username,
                'password' => $password,
            ]);

            //Assert that it did NOT succeeded and received the token
            if ($response->status() !== 401) {
                dump($response->getContent());
            }
            $response->assertStatus(401);
        }
    }

    /**
     *Test login with wrong password
     */
    public function test_login_with_wrong_password()
    {
        $password = $this->faker->password(8, 20);
        $user = factory(User::class)->create([
            'password' => bcrypt($password)
        ]);

        //try logging in 10 times with wrong password
        for ($i = 0; $i <= 10; $i++) {
            $response = $this->json('POST', route('api.authenticate'), [
                'username' => $user->username,
                'password' => $this->faker->password(8, 20),
            ]);

            //Assert that it did NOT succeeded and received the token
            if ($response->status() !== 401) {
                dump($response->getContent());
            }
            $response->assertStatus(401);
        }
    }
}