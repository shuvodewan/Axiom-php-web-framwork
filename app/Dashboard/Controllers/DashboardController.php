<?php

namespace App\Dashboard\Controllers;

use Axiom\Application\Base\Controller;
use App\Dashboard\Services\DashboardService;
use Axiom\Core\Attribute\Get;

/**
 * Controller for handling HTTP requests
 *
 * Responsible for processing incoming requests, delegating business logic
 * to the service layer, and returning appropriate responses.
 * Uses attribute-based routing from Axiom framework core.
 *
 * @package App\Dashboard\Controllers
 */
class DashboardController  extends Controller
{
    /**
     * @var The service class this controller depends on
     * @see DashboardService
     */
    protected $serviceable = DashboardService::class;

    #[Get(uri:'/', name:'index')]
    public function index($request){
        $this->view('backend.intruduction');
    }
}
