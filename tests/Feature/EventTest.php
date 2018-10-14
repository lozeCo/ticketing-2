<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EventTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testEventsCanBeRetrieved()
    {
        // Arrange

        // Act
        $response = $this->get('api/events');

        // Assert
        $response->assertStatus(200);
    		$response->assertJsonStructure([
    			"status", "code", "messages", "data" => [
    				"events"
    			]
    		]);
    }

    public function testEventsCanBeFiltered()
  	{
  		$event = factory(\App\Event::class)->create([
  			'name' => 'Evento de prueba'
  		]);
      $event = factory(\App\Event::class)->create([
  			'name' => 'Otro evento'
  		]);
  		$response = $this->get("api/events?name=prueba");
      //dd($response);
  		$response->assertStatus(200);
  		$response->assertJsonStructure([
  			"status", "code", "messages", "data" => [
  				"events" => [
            ['id', 'name']
          ]
  			]
  		]);
  		$response->assertSee('Evento de prueba');
      $response->assertDontSee('Otro evento');
  	}
}
