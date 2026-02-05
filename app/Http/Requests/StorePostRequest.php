<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $postId = $this->route('post')?->id;

        return [
            'title' => 'required|string|max:200',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'status' => 'required|in:draft,published',
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Please enter a title for your post.',
            'title.max' => 'Title is too long (maximum 200 characters).',
            'content.required' => 'Please enter content for your post.',
            'featured_image.image' => 'The uploaded file must be an image.',
            'featured_image.mimes' => 'Only JPG, PNG, and WebP images are allowed.',
            'featured_image.max' => 'Image is too large. Maximum size is 5MB.',
        ];
    }
}
