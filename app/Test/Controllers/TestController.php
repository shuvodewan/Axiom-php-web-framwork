<?php

namespace App\Test\Controllers;

use App\Test\Services\TestService;
use Axiom\Application\Base\Controller;
use Axiom\Core\Attribute\Get;
use Axiom\Facade\Vite;

class TestController  extends Controller
{
    protected $serviceable = TestService::class;

    #[Get(uri:'/', name:'index')]
    public function index(){
        $features = $this->service->index();
        dd(Vite::load([]));
       $this->view(template: 'frontend.home', data: [
        'features' => $features
     ]);
    }
}
