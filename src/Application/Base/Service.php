<?php

namespace Axiom\Application\Base;

use Axiom\Core\ServiceProxy;
use Axiom\Facade\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Base service class providing CRUD operations for entities
 * 
 * @template T of Model
 */
class Service
{
    /**
     * The entity class associated with this service
     * 
     */
    protected $entity;

    /**
     * Create a new service proxy instance for fluent service initialization
     * 
     * @return ServiceProxy<static> 
     */
    public static function initiate(): ServiceProxy
    {
        return new ServiceProxy(static::class);
    }

    /**
     * Builds a query with filters and sorting
     * 
     * @param array{
     *     scopes?: array,
     *     order_by?: string,
     *     sort?: 'asc'|'desc'
     * } $filters
     * 
     * @return Builder<T>
     */
    protected function getQuery(array $filters = [])
    {
        $scopes = Arr::has($filters, 'scopes') ? $filters['scopes'] : [];
        $orderBy = Arr::has($filters, 'order_by') ? $filters['order_by'] : 'id';
        $sort = Arr::has($filters, 'sort') ? $filters['sort'] : 'desc';
        
        return $this->entity::filters($scopes)->orderBy($orderBy, $sort);
    }

    /**
     * Retrieves an entity by ID or returns the object if already an entity
     * 
     * @param int|string|Model $id
     * @param array{
     *     scopes?: array,
     *     order_by?: string,
     *     sort?: 'asc'|'desc'
     * } $filters
     * @param callable|null $callback Optional callback to modify the query
     * 
     * @return T|null
     */
    protected function getEntity($id, array $filters = [], ?callable $callback = null)
    {
        if (is_object($id)) {
            return $id;
        }

        $query = $this->getQuery($filters);
        
        if (is_callable($callback)) {
            call_user_func($callback, $query);
        }

        return $query->find($id);
    }

    /**
     * Creates a new instance of the entity
     * 
     * @return 
     */
    public function getEntityInstance()
    {
        return new $this->entity();
    }

    /**
     * get result
     * 
     * @return T
     */
    public function get(Array $filters=[],$paginate=false,$limit = 25, $page = 0, $pageName = 'page',$appends=[])
    {
        $query=$this->getQuery($filters);
        return $paginate? $query->paginate($limit,$pageName, $page)->appends($appends):$query->get();
    }


    /**
     * Stores a new entity with the given data
     * 
     * @param array<string, mixed> $data
     * @return T
     */
    public function store(array $data)
    {
        return $this->entity::create($data);
    }

    /**
     * Retrieves an entity by ID
     * 
     * @param int|string|Entity $id
     * @param array{
     *     scopes?: array,
     *     order_by?: string,
     *     sort?: 'asc'|'desc'
     * } $filters
     * @return T|null
     */
    public function show($id, array $filters = [])
    {
        return $this->getEntity($id, $filters);
    }

    /**
     * Updates an entity with the given data
     * 
     * @param int|string|Entity $id
     * @param array<string, mixed> $data
     * @param array{
     *     scopes?: array,
     *     order_by?: string,
     *     sort?: 'asc'|'desc'
     * } $filters
     * @return T|null
     */
    public function update($id, array $data, array $filters = [])
    {
        $entity = $this->getEntity($id, $filters);
        
        if ($entity) {
            $entity->update($data);
        }
        
        return $entity;
    }

    /**
     * Deletes an entity
     * 
     * @param int|string|Model $id
     * @param array{
     *     scopes?: array,
     *     order_by?: string,
     *     sort?: 'asc'|'desc'
     * } $filters
     * @return bool
     */
    public function destroy($id, array $filters = []): bool
    {
        $entity = $this->getEntity($id, $filters);
        
        if ($entity) {
            return $entity->delete();
        }
        
        return false;
    }
}