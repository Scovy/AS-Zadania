<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TagRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        $tagId = $this->route('tag') ? $this->route('tag')->id : null;

        return [
            'nazwa' => [
                'required',
                'string',
                'max:50',
                Rule::unique('tags')->ignore($tagId),
            ],
        ];
    }
}
