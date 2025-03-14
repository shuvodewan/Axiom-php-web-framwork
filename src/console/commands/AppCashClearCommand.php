<?php

namespace Core\console\commands;

use Core\console\Command;
use Core\facade\Cache;

class AppCashClearCommand extends Command
{
    protected function validator():array
    {
        return [];
    }

    
    public function handle(){
        $this->start('App cache cleaning');
        $this->empty();

        Cache::setSubDir('service')->clear();

        $this->end('App cache cleaning end');
    }
}