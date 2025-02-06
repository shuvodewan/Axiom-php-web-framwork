<?php

namespace App\views\render;

use Core\View;
use Core\facade\Auth;

class LandingView extends View
{
    protected function composer():array{
        return [
            'user'=>Auth::user()
        ];
    }
}