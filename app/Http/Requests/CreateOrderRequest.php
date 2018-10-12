<?php

namespace App\Http\Requests;

class CreateOrderRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ticket_id' => 'required|array|tickets_are_available',
        ];
    }

    public function messages()
    {
      return [
        'ticket_id.tickets_are_available' => 'Requested tickets are no longer available'
      ];
    }
}
