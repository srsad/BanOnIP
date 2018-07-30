<?php

return [
    'BanOnIP' => [
        'file' => 'banonip',
        'description' => '',
        'static' => true,
        'events' => [
            'OnManagerPageBeforeRender' => [],
            'OnWebPagePrerender' => []
        ],
    ],
];