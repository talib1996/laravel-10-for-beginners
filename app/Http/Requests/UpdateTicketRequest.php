<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\TicketStatus;
class UpdateTicketRequest extends FormRequest
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
        // dd(array_column(TicketStatus::cases(), 'value'));
        return [
            //
            'title' => ['string', 'max:255'],
            'description' => ['string'],
            'status' => ['string', Rule::in(array_column(TicketStatus::cases(), 'value'))],
            'attachment' => ['file', 'mimes:jpg,jpeg,png,pdf']
        ];
    }
}
