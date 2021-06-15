<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;


class UserManagementTest extends TestCase
{
    use RefreshDatabase;
    
    protected $BASE_URL = "https://prueba-php-laravel-backend.herokuapp.com/api/";

    /** @test */
    public function a_list_of_user_can_be_retrieved()
    {
        $this->withoutExceptionHandling();
        User::factory(2)->create();
        $response = $this->get($this->BASE_URL . 'users');
        $users = User::all();
        $response->assertOk();
        $response->assertJson([
            'data' => [
                [
                    'data' => [
                        'type' => 'users',
                        'user_id' => $users->first()->id,
                        'attributes' => [
                            'nombres' => $users->first()->nombres,
                            'apellidos' => $users->first()->apellidos,
                            'cedula' => $users->first()->cedula,
                            'correo' => $users->first()->correo,
                            'telefono' => $users->first()->telefono,
                        ]
                    ]
                ],
                [
                    'data' => [
                        'type' => 'users',
                        'user_id' => $users->last()->id,
                        'attributes' => [
                            'nombres' => $users->last()->nombres,
                            'apellidos' => $users->last()->apellidos,
                            'cedula' => $users->last()->cedula,
                            'correo' => $users->last()->correo,
                            'telefono' => $users->last()->telefono,
                        ]
                    ]
                ]
            ]
        ]);
    }

    /** @test */
    public function a_user_can_be_retrived()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $response = $this->get($this->BASE_URL . 'users/'. $user->id);
        $users = User::first();
        $response->assertOk();
        $response->assertJson([
            'data' => [
                'type' => 'users',
                'user_id' => $users->id,
                'attributes' => [
                    'nombres' => $users->nombres,
                    'apellidos' => $users->apellidos,
                    'cedula' => $users->cedula,
                    'correo' => $users->correo,
                    'telefono' => $users->telefono,
                ]
            ]
        ]);
    }

    /** @test */
    public function a_user_can_be_created()
    {
        $this->withoutExceptionHandling();

        $response = $this->post($this->BASE_URL . "users", [
            'nombres' => 'Elkin',
            'apellidos' => 'de Armas',
            'cedula' => '123',
            'correo' => 'elkin@gmail.com',
            'telefono' => 34566
        ])->assertCreated();
        
        $this->assertCount(1, User::all());
        
        $user = User::first();

        $this->assertEquals($user->nombres, 'Elkin');
        $this->assertEquals($user->apellidos, 'de Armas');
        $this->assertEquals($user->cedula, '123');
        $this->assertEquals($user->correo, 'elkin@gmail.com');
        $this->assertEquals($user->telefono, '34566');

        $response->assertJson([
            'data' => [
                'type' => 'users',
                'user_id' => $user->id,
                'attributes' => [
                    'nombres' => $user->nombres,
                    'apellidos' => $user->apellidos,
                    'cedula' => $user->cedula,
                    'correo' => $user->correo,
                    'telefono' => $user->telefono
                ]
            ]
        ]);
    }

    /** @test */
    public function a_user_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $response = $this->put($this->BASE_URL . "users/{$user->id}", [
            'nombres' => 'Elkin',
            'apellidos' => 'de Armas',
            'cedula' => 1234,
            'correo' => 'elkin@gmail.com',
            'telefono' => 34566
        ]);
        
        
        $this->assertCount(1, User::all());
        
        $user = $user->fresh();
        
        $this->assertEquals($user->nombres, 'Elkin');
        $this->assertEquals($user->apellidos, 'de Armas');
        $this->assertEquals($user->cedula, '1234');
        $this->assertEquals($user->correo, 'elkin@gmail.com');
        $this->assertEquals($user->telefono, '34566');

        $response->assertJson([
            'data' => [
                'type' => 'users',
                'user_id' => $user->id,
                'attributes' => [
                    'nombres' => $user->nombres,
                    'apellidos' => $user->apellidos,
                    'cedula' => $user->cedula,
                    'correo' => $user->correo,
                    'telefono' => $user->telefono
                ]
            ]
        ]);
    }

    /** @test */
    public function a_user_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $response = $this->delete($this->BASE_URL . "user/{$user->id}")->assertNoContent();

        $this->assertCount(0, User::all());
    }

    
    
}
