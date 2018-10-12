<?php
namespace App\Transformers;
abstract class BaseTransformer{

	public function transformCollection(array $items)
  {
  	return array_map([$this, 'transform'], $items);
  }

    public abstract function transform($item);

}
