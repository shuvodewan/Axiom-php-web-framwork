<?php

namespace Core\contract;

interface RepositoryContract
{
    public function mutation(&$data, $type='create');

    public function all($raw = false,$paginate = false, $page = 1, $perPage = 15);

    public function paginate($page = 1, $perPage = 15, $raw = false);

    public function count();

    public function find($id, $raw = false);

    public function create($data, $raw = false);

    public function update($id, $data);

    public function delete($id);

    public function hydrate($rows);

    public function makeModelObject($row);
    
}