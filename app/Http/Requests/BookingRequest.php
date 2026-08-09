<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'max:100'],
            'phone'         => ['required', 'string', 'max:20'],
            'email'         => ['nullable', 'email', 'max:150'],
            'preferred_date'=> ['nullable', 'date', 'after:today'],
            'message'       => ['nullable', 'string', 'max:1000'],
        ];
    }
}
