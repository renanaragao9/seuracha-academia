<?php

return [
    'default_model' => env('OPENROUTER_DEFAULT_MODEL', 'openai/gpt-4o-mini'),

    'temperature' => (float) env('OPENROUTER_TEMPERATURE', 0.7),

    'max_tokens' => (int) env('OPENROUTER_MAX_TOKENS', 2000),

    'models' => [
        'fast' => [
            'openai/gpt-4o-mini',
            'anthropic/claude-3-haiku',
            'mistral/mistral-small',
        ],
        'balanced' => [
            'openai/gpt-4-turbo',
            'anthropic/claude-3-sonnet',
            'google/gemini-2.0-flash',
        ],
        'powerful' => [
            'openai/gpt-4o',
            'anthropic/claude-3-opus',
            'deepseek/deepseek-chat',
        ],
    ],

    'services' => [
        'training_plan' => [
            'model' => 'openai/gpt-4o-mini',
            'temperature' => 0.6,
            'max_tokens' => 4000,
        ],
        'nutrition_plan' => [
            'model' => 'openai/gpt-4o-mini',
            'temperature' => 0.5,
            'max_tokens' => 3000,
        ],
        'assessment' => [
            'model' => 'openai/gpt-4-turbo',
            'temperature' => 0.4,
            'max_tokens' => 2000,
        ],
    ],
];
