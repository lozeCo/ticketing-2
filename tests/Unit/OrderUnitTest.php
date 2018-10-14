<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Mockery;

class OrderUnitTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testJSONIsReturnedWhenPaymentGatewayThrowsException()
    {

      // Arrange
      $fakePaymentGateway = Mockery::mock('\App\Interfaces\PaymentGateway');
      $fakePaymentGateway->shouldReceive('setApiKey');
      $fakePaymentGateway->shouldReceive('charge')->andThrow('Exception');

      $fakeTicketRepository     = Mockery::mock('\App\Ticket');
      $fakeTicketRepository->shouldReceive('find')->andReturn(
        new \App\Ticket
      ) ;
      $fakeRequest              = Mockery::mock('\App\Http\Requests\CreateOrderRequest');
      $fakeRequest->ticket_id   = [1];
      $fakeTicketTransformer    = Mockery::mock('\App\Transformers\TicketTransformer');
      $fakeOrderTransformer     = Mockery::mock('\App\Transformers\OrderTransformer');

      // Act
      $ordersController = new \App\Http\Controllers\Api\OrdersController($fakePaymentGateway);
      $response = $ordersController->store($fakeTicketRepository, $fakeRequest, $fakeTicketTransformer, $fakeOrderTransformer);

      // Assert
      $this->assertTrue($response->getStatusCode() == 400);
      json_decode($response->getContent());
      $this->assertTrue(json_last_error() == JSON_ERROR_NONE);

    }
}
