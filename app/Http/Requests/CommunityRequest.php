<?php

namespace App\Http\Requests;

use App\Models\Community;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CommunityRequest extends FormRequest
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
        $slug = $this->route('slug');

        $community = $slug ? Community::where('slug', $slug)->first() : null;

        return [
            'name' => 'required|string|max:100|min:4',
            'slug' => ['required', 'string', 'max:100', Rule::unique('communities', 'slug')->ignore($community?->id)],
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
 
            'profile_pic' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'banner_img' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',

            'visibility' => 'required|in:public,private',

            'posting_mode' => 'required|in:members,admins',
            'commenting_mode' => 'required|in:everyone,members',

            'requires_join_approval' => 'nullable|boolean',
        ];
    }

    public function messages() 
    {
        return [
            'name.required' => 'Write a name dude...',
            'slug.required' => 'Slug is the real identity. Must be there.' ,
            'category_id.required' => 'It must be in a category.',
        ];
    }
}
