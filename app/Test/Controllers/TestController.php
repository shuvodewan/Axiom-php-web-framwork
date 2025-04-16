<?php

namespace App\Test\Controllers;

use App\Test\Services\TestService;
use Axiom\Application\Base\Controller;
use Axiom\Core\Attribute\Get;

class TestController  extends Controller
{
    protected $serviceable = TestService::class;

    #[Get(uri:'/', name:'index')]
    // public function index(){
    //     $features = $this->service->index();

    //    $this->view(template: 'landing.home', data: [
    //     'features' => $features
    //  ]);
    // }
}
