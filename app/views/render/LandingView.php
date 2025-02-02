<?php

namespace App\views\render;

use Core\View;
use Facade\Auth;

class LandingView extends View
{
    protected function composer():array{
        return [
            'user'=>Auth::user()
        ];
    }
}