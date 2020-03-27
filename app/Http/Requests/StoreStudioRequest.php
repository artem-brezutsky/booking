<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStudioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Валидация данных для создания и изменения "комнаты"
     *
     * @return array
     */
    public function rules(): array
    {
        $uniqueRuleName = Rule::unique('studios', 'name')->ignore($this->route('studio'));
        $uniqueRuleSlug = Rule::unique('studios', 'slug')->ignore($this->route('studio'));
        return [
            'studio-name' => ['required', 'max:25', $uniqueRuleName],
            'description' => 'required',
            'slug'        => ['required', 'regex:/^[\d\w\s-]+$/u', 'max:25', $uniqueRuleSlug],
        ];
    }
}
