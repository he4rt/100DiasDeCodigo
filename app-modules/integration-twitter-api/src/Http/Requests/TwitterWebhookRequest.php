<?php

declare(strict_types=1);

namespace He4rt\IntegrationTwitterApi\Http\Requests;

use He4rt\IntegrationTwitterApi\Endpoints\Webhook\TwitterWebhookResponse;
use Illuminate\Foundation\Http\FormRequest;

class TwitterWebhookRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'rule_id' => ['required', 'string'],
            'rule_tag' => ['required', 'string'],
            'rule_value' => ['required', 'string'],
            'event_type' => ['required', 'string'],
            'timestamp' => ['required'],
            'tweets' => ['required', 'array'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function toDto(): TwitterWebhookResponse
    {
        return TwitterWebhookResponse::fromArray([
            'tweets' => $this->input('tweets'),
        ]);
    }
}
