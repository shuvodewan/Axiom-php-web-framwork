<?php

namespace Axiom\Application\Base;

trait ResourceTrait
{
    protected function getQuery(array $filters=[])
    {

        $scopes = isset($filters['scopes']) ? $filters['scopes'] : [];
        $orderBy = isset($filters['order_by']) ? $filters['order_by'] : 'id';
        $sort = isset($filters['sort']) ? $filters['sort'] : 'desc';
        
        return $this->entity::filters($scopes)->orderBy($orderBy, $sort);
    }


    protected function getModel($id, array $filters=[], $callback = null)
    {

        if(is_object($id)){
            return $id;
        }

        $query = $this->getQuery($filters);
        
        if (is_callable($callback)) {
            call_user_func($callback, $query);
        }

        return $model = $query->find($id);
    }
}