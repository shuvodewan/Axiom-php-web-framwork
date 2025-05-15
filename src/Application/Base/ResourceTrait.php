<?php

namespace Axiom\Application\Base;

use Axiom\Facade\Arr;

trait ResourceTrait
{
    protected function getQuery(array $filters=[])
    {

        $scopes = Arr::has($filters,'scopes') ? $filters['scopes'] : [];
        $orderBy =  Arr::has($filters,'order_by') ? $filters['order_by'] : 'id';
        $sort = Arr::has($filters,'sort') ? $filters['sort'] : 'desc';
        
        return $this->entity::filters($scopes)->orderBy($orderBy, $sort);
    }


    protected function getEntity($id, array $filters=[], $callback = null)
    {

        if(is_object($id)){
            return $id;
        }

        $query = $this->getQuery($filters);
        
        if (is_callable($callback)) {
            call_user_func($callback, $query);
        }

        return $entity = $query->find($id);
    }


    public function getEntityInstance()
    {
        return new $this->entity();
    }
}