<?php
namespace App\Transformers;

use App\Transformers\BaseTransformer;

class TicketTransformer extends BaseTransformer {

	public function transform($ticket){
		$transformation = [];

		$transformation['id'] 				    = $ticket['id'];
		$transformation['seat_number']	 = $ticket['seat_number'];
    $transformation['available']	   = boolval($ticket['available']);
    $transformation['price']	       = bcdiv($ticket['price'], "100", 2);

		return $transformation;
	}

}
