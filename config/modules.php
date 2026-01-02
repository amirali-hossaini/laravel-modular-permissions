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
];
