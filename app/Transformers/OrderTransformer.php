<?php
namespace App\Transformers;

use App\Transformers\BaseTransformer;

class OrderTransformer extends BaseTransformer {

	public function transform($order){
		$transformation = [];

    $transformation['id']    = $order['id'];
    $transformation['customer_name']      = $order['customer_name'];
    $transformation['customer_email']     = $order['customer_email'];
    $transformation['total']              = bcdiv($order['total'], 100, 2);
    $transformation['confirmation_code']  = $order['confirmation_code'];

		return $transformation;
	}

}
