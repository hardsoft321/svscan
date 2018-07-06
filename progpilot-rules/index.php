<?php
return [
    'sinks' => [
        __DIR__ . '/../vendor/designsecurity/progpilot/package/src/uptodate_data/sinks.json',
        __DIR__ . '/sinks.json',
    ],
    'sources' => [
        __DIR__ . '/../vendor/designsecurity/progpilot/package/src/uptodate_data/sources.json',
    ],
    'validators' => [
        __DIR__ . '/../vendor/designsecurity/progpilot/package/src/uptodate_data/validators.json',
    ],
    'sanitizers' => [
        __DIR__ . '/../vendor/designsecurity/progpilot/package/src/uptodate_data/sanitizers.json',
        __DIR__ . '/sanitizers.json',
    ]
];
