<?php

namespace App\Http\Requests\News;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FilterRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

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
            'page' => [
                'sometimes',
                'integer'
            ],
            'currency' => [
                'nullable',
                'integer',
                Rule::exists('currencies', 'id')
            ],
            'start_date' => [
                'nullable',
                'date',
            ],
            'end_date' => [
                'nullable',
                'date',
            ]
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $startDate = $this->input('start_date');
            $endDate = $this->input('end_date');

            if ($endDate && $startDate && strtotime($startDate) > strtotime($endDate)) {
                $validator->errors()->add('start_date', 'Start date must be before end date.');
            }

            if ($startDate && $endDate && strtotime($endDate) < strtotime($startDate)) {
                $validator->errors()->add('end_date', 'End date must be after start date.');
            }
        });
    }
}
