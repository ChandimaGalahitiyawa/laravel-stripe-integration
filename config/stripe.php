<?php

return [
    'stripe_publishable_key' => env('STRIPE_PUBLISHABLE_KEY'),
    'stripe_secret_key' => env('STRIPE_SECRET_KEY'),

    'product' =>[
        'name' => 'Watch',
        'description' => 'Elevate your style with this chic watch, perfect for any occasion.',
        'price' => 1000, 
    ]
];
