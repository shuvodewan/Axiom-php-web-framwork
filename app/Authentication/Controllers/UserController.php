<?php

namespace App\Authentication\Controllers;

use Axiom\Application\Base\Controller;
use App\Authentication\Services\UserService;


/**
 * Controller for handling HTTP requests
 *
 * Responsible for processing incoming requests, delegating business logic
 * to the service layer, and returning appropriate responses.
 * Uses attribute-based routing from Axiom framework core.
 *
 * @package App\Authentication\Controllers
 */
class UserController  extends Controller
{
    /**
     * @var The service class this controller depends on
     * @see UserService
     */
    protected $serviceable = UserService::class;
}
