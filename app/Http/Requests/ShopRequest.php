<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            'postal_code' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'open_time' => 'required|date_format:H:i',
            'close_time' => 'required|date_format:H:i|after:open_time',
            'category_id' => 'required|exists:categories,id',
            'price_id' => 'required|exists:prices,id',
            'weekdays' => 'nullable|array',
            'weekdays.*' => 'integer|between:0,6',
        ];
    }
}
