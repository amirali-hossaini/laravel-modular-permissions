<?php

return [
    /*
     * Authentication settings for token-based authentication.
     */
    'authentication' => [
        /*
         * The name of the token used in Sanctum.
         * Common examples: 'authentication_token', 'api_token', 'bearer_token'
         */
        'token_key' => 'authentication_token',

        /*
         * Token time-to-live (expiration) in hours.
         * After this period, the token will no longer be valid.
         */
        'token_ttl_hours' => 24,
    ],

    /**
     * Access Control module settings
     */
    'access_control' => [
        'cache' => [
            /**
             * User permissions cache TTL in minutes.
             * Suggested range: 30–60 minutes.
             */
            'ttl_minutes' => 60,

            /**
             * Cache key prefix for user permission entries.
             */
            'prefix' => 'user_permissions',
        ],
    ],
];
