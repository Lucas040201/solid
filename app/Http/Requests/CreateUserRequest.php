<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class CreateUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email',
            'document' => 'required',
            'password' => 'required'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        $errors = str_replace("\n", "\n", implode(";" , array_map(function ($arr) {
            return implode(";" , $arr);
        }, $errors)));
        throw new HttpResponseException(
            response()->json(['error' => true, 'message' => $errors], Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
