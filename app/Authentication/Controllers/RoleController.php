<?php

namespace App\Authentication\Controllers;

use Axiom\Application\Base\Controller;
use App\Authentication\Services\RoleService;
use Axiom\Core\Attribute\Get;

/**
 * Controller for handling HTTP requests
 *
 * Responsible for processing incoming requests, delegating business logic
 * to the service layer, and returning appropriate responses.
 * Uses attribute-based routing from Axiom framework core.
 *
 * @package App\Authentication\Controllers
 */
class RoleController  extends Controller
{
    /**
     * @var The service class this controller depends on
     * @see RoleService
     */
    protected $serviceable = RoleService::class;

    #[Get('roles/index', name:'roles')]
    public function index($request)
    {
        $this->service->index();
    }
}
