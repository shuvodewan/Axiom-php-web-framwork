<?php

namespace App\Axiom\Controllers;

use Axiom\Application\Base\Controller;
use App\Axiom\Services\AxiomService;
use Axiom\Core\Attribute\Get;

/**
 * Controller for handling HTTP requests
 *
 * Responsible for processing incoming requests, delegating business logic
 * to the service layer, and returning appropriate responses.
 * Uses attribute-based routing from Axiom framework core.
 *
 * @package App\Axiom\Controllers
 */
class AxiomController  extends Controller
{
    /**
     * @var The service class this controller depends on
     * @see AxiomService
     */
    protected $serviceable = AxiomService::class;

    #[Get(uri:'/', name:'home')]
    public function home(){
        
    }
}
