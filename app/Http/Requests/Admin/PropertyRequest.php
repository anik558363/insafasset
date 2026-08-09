<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PropertyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'         => ['required', 'string', 'max:200'],
            'description'   => ['required', 'string'],
            'category_id'   => ['required', 'exists:categories,id'],
            'type'          => ['required', 'in:land,flat,house,commercial'],
            'listing_type'  => ['required', 'in:sale,rent'],
            'price'         => ['required', 'numeric', 'min:0'],
            'price_unit'    => ['nullable', 'string', 'max:30'],
            'size'          => ['required', 'numeric', 'min:0'],
            'size_unit'     => ['required', 'in:katha,bigha,decimal,sft,acre'],
            'bedrooms'      => ['nullable', 'integer', 'min:0'],
            'bathrooms'     => ['nullable', 'integer', 'min:0'],
            'location_text' => ['required', 'string', 'max:255'],
            'division'      => ['nullable', 'string', 'max:100'],
            'district'      => ['nullable', 'string', 'max:100'],
            'area'          => ['nullable', 'string', 'max:100'],
            'latitude'      => ['nullable', 'numeric'],
            'longitude'     => ['nullable', 'numeric'],
            'youtube_link'       => ['nullable', 'max:255'],
            'facebook_video_url' => ['nullable', 'url', 'max:500'],
            'status'        => ['required', 'in:available,booked,sold,rented'],
            'featured'      => ['boolean'],
            'meta_title'    => ['nullable', 'string', 'max:200'],
            'meta_description' => ['nullable', 'string', 'max:300'],
            'images'        => ['nullable', 'array'],
            'images.*'      => ['image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'agent_name' => ['nullable', 'string', 'max:255'],
            'agent_phone' => ['nullable', 'string', 'max:50'],
        ];
    }
}
