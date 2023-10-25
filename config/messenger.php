<?php

    return [
        'slack' => [
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
        ],

        'telegram' => [
            'url' => 'https://api.telegram.org/bot' . env('TELEGRAM_BOT_TOKEN') . '/sendMessage',
            'token' => env('TELEGRAM_BOT_TOKEN'),
            'chat_id' => env('TELEGRAM_CHAT_ID'),
        ]
    ];
