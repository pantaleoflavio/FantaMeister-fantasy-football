<?php

return [
    'code' => env('COMPETITION_CODE', 'default_competition'),
    'name' => env('COMPETITION_NAME', 'My Fantasy Competition'),
    'season' => env('COMPETITION_SEASON', '2026-2027'),
    'branding' => [
        'primary_color' => env('BRANDING_PRIMARY_COLOR', '#1f2937'),
        'accent_color' => env('BRANDING_ACCENT_COLOR', '#22c55e'),
        'logo_url' => env('BRANDING_LOGO_URL', null),
    ],
    'league_modes' => [
        'classic',
        'formula_one',
        'head_to_head',
    ],
];