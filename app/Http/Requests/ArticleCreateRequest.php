<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ArticleCreateRequest extends Request
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
            'title' => 'required|max:100',
            'slug' => 'required|max:255',
            'contents' => 'required|max:100000',
            'image_path' => 'image|file|max:255',
            'article_category_id' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [];
    }
}