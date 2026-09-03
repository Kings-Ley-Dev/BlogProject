<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
        ];

        if ($this->isMethod('POST')) {
            $rules['featured_image'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
        } else {
            $rules['featured_image'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'title.required' => 'The post title is required.',
            'excerpt.required' => 'The excerpt is required.',
            'content.required' => 'The content is required.',
            'category_id.required' => 'Please select a category.',
            'featured_image.required' => 'Please upload a featured image.',
            'featured_image.image' => 'The featured image must be an image file.',
        ];
    }
}
