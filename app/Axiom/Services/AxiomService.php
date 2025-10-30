<?php

namespace App\Axiom\Services;

use App\Axiom\Entities\Axiom;
use Axiom\Application\Base\Service;


/**
 * Service layer for domain business logic
 *
 * Handles all business logic operations related to Entities.
 * Serves as an intermediary between controllers and the data access layer (Doctrine entities).
 * 
 * @package App\Axiom\Services
 */
class AxiomService extends Service
{
     
    public function document($version, $page){
        return [
            'page'=>'frontend/docs/' . $version. '/' . $page .'.twig',
            'title'=>$page
        ];
    }
}