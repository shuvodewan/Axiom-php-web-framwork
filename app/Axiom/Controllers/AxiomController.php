<?php

namespace App\Axiom\Controllers;

use App\Authentication\Entities\User;
use Axiom\Application\Base\Controller;
use App\Axiom\Services\AxiomService;
use App\Axiom\Transformers\TestTransformer;
use Axiom\Core\Attribute\Get;
use Axiom\Http\ResponseTrait;
use Axiom\Templating\Table\TableBuilder;

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
    use ResponseTrait;
    /**
     * @var The service class this controller depends on
     * @see AxiomService
     */
    protected $serviceable = AxiomService::class;

    #[Get(uri:'/', name:'axiom.home')]
    public function index($request){
        $users= User::paginate(50);
        // $this->response((new TestTransformer($users))->getResource()->value());
        $transformer = new TestTransformer($users);
        
        $table = new TableBuilder('users-table');
        $table->setData($transformer)
            ->setPerPage(10)
            ->addColumn('name', 'Name', ['sortable' => true])
            ->addColumn('email', 'Email', ['sortable' => true])
            ->addColumn('roles.title', 'Role', ['sortable' => true])
            ->addFilter('name', 'text', ['placeholder' => 'Filter by name'])
            ->addFilter('email', 'text', ['placeholder' => 'Filter by email'])
            ->addAction('edit', 'Edit', [
                'url' => '/users/{id}/edit',
                'icon' => '<svg class="w-4 h-4">...</svg>'
            ])
            ->addBulkAction('delete', 'Delete Selected', [
                'url' => '/users/bulk-delete',
                'method' => 'DELETE',
                'confirm' => 'Are you sure you want to delete selected users?'
            ]);

            
        $this->view(template: 'backend.index',data:[
            'table' => $table->render()
        ]);
    }



    #[Get(uri:'/documentation/{version}/{page}', name:'axiom.docs')]
    public function documentation($request, $version,$page){
        $this->view(template: 'frontend.documentation', data: $this->service->document($version, $page));
    }
}
