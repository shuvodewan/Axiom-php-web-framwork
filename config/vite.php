<?php

return [
    'dev_server' => env('VITE_DEV_SERVER', 'http://localhost:5173'),
    'build_dir' => env('VITE_BUILD_DIR', 'public/build'),
    'manifest_file' => env('VITE_MANIFEST_FILE', 'manifest.json'),
    'hot_file' => env('VITE_HOT_FILE', 'hot'),
];
