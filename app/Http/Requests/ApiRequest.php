<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ApiRequest extends Request
{
	private $apiConroller;

	public function __construct(\App\Http\Controllers\Api\ApiController $apiController = null){
		$this->apiController = $apiController;
	}

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

	public function response(array $errors){
		return $this->apiController->respondWithValidationErrors(call_user_func_array('array_merge_recursive', $errors));
	}

}
