<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PostUpdateRequest extends FormRequest
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
            'section_id' => 'nullable|exists:community_sections,id',
            'content' => 'nullable|string|max:40000',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:40000',
            'comments_enabled' => 'nullable',
            'is_sensitive' => 'nullable',
            'deleted_media_ids' => 'nullable|array',
            'deleted_media_ids.*' => 'integer|exists:media,id',
            'media' => 'nullable|array',
            'media.*' => 'file|mimes:jpg,jpeg,png,webp,gif,mp4,webm|max:51200',
        ];
    }
}
