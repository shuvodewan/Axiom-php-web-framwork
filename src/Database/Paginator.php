<?php

namespace Axiom\Database;

use Axiom\Facade\Url;
use Axiom\Http\Request;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator as Paginate;

class Paginator
{
    private $items = [];
    private $total;
    private $perPage;
    private $currentPage;
    private $lastPage;
    private $pageName;
    private $from = 0;
    private $to = 0;
    private $queryParams = [];
    private $request;

    public function __construct($items, int $total, int $perPage, int $currentPage, string $page)
    {
        $this->request= Request::getInstance();
        $this->setProperties($items,$total,$perPage,$currentPage,$page);
    }

    public function setProperties($items, int $total, int $perPage, int $currentPage, string $page){
        $this->total = $total;
        $this->pageName = $page;
        $this->perPage = $perPage;
        $this->currentPage = $currentPage??$this->request->getQuery($page);
        $this->lastPage = max((int) ceil($total / $perPage), 1);

        if($this->currentPage <= $this->lastPage){
            $this->items = $items;
            $this->from = $this->currentPage > 1 ? ($this->currentPage - 1) * $this->perPage + 1 : 1;
            $this->to = min($this->currentPage * $this->perPage, $this->total);
        }
    }

    public static function fromQueryBuilder(QueryBuilder $queryBuilder, int $perPage = 15, int $currentPage = 0, $page='page'): self
    {
        $query = clone $queryBuilder;
        
        $query->setFirstResult(($currentPage - 1) * $perPage)
              ->setMaxResults($perPage);

        $paginator = new Paginate($query, true);
        $total = count($paginator);
        $results = iterator_to_array($paginator);

        return new self($results, $total, $perPage, $currentPage, $page);
    }

    // Getters
    public function items(): array { return $this->items; }
    public function total(): int { return $this->total; }
    public function perPage(): int { return $this->perPage; }
    public function currentPage(): int { return $this->currentPage; }
    public function lastPage(): int { return $this->lastPage; }
    public function from(): int { return $this->from; }
    public function to(): int { return $this->to; }
    public function hasMorePages(): bool { return $this->currentPage < $this->lastPage; }

    // Additional methods
    public function firstItem(): ?int { return $this->total > 0 ? $this->from : null; }
    public function lastItem(): ?int { return $this->total > 0 ? $this->to : null; }
    public function isEmpty(): bool { return empty($this->items); }
    public function isNotEmpty(): bool { return !$this->isEmpty(); }

    public function append(array $params=[]){
        $this->queryParams = $params;
    }

    private function url(): string
    {
        $queryParams = $this->queryParams;
        $queryParams[$this->pageName] = $this->currentPage;

        return Url::to(parameters: $queryParams);
    }


    public function meta():array
    {
        return [
            'current_page' => $this->currentPage(),
            'from' => $this->firstItem(),
            'last_page' => $this->lastPage(),
            'per_page' => $this->perPage(),
            'to' => $this->lastItem(),
            'total' => $this->total(),
            'path' => Url::base(),
        ];
    }



    public function links():array
    {
        return [
            'first' => $this->url(1),
            'last' => $this->url($this->lastPage()),
            'prev' => $this->currentPage() > 1 ? $this->url($this->currentPage() - 1) : null,
            'next' => $this->hasMorePages() ? $this->url($this->currentPage() + 1) : null,
        ];
    }


    public function toArray(): array
    {
        return [
            'data' => $this->items(),
            'meta' => $this->meta(),
            'links' => $this->links(),
        ];
    }
}