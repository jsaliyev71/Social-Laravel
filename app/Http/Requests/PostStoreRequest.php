<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
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
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'community_id' => 'nullable|exists:communities,id',
            'section_id' => 'nullable|exists:community_sections,id',
            'title' => 'required|string|max:255',
            'post_type' => 'required|in:text,image',
            'content' => 'nullable|string|max:40000',
            'description' => 'nullable|string|max:40000',
            'comments_enabled' => 'nullable',
            'is_sensitive' => 'nullable',
            'media' => 'nullable|array',
            'media.*' => 'file|mimes:jpg,jpeg,png,webp,gif,mp4,webm|max:51200',
        ];
    }
}
