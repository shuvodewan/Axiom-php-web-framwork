<?php

namespace Axiom\Database;

use Axiom\Http\Request;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

class LengthAwarePaginator
{
    private $items;
    private $total;
    private $perPage;
    private $currentPage;
    private $lastPage;
    private $from;
    private $to;
    private $queryParams;
    private $request;

    public function __construct($items, int $total, int $perPage, int $currentPage, string $page)
    {
        $this->request= Request::getInstance();
        $this->items = $items;
        $this->total = $total;
        $this->perPage = $perPage;
        $this->currentPage = $currentPage??$this->request->getQuery($page);
        $this->lastPage = max((int) ceil($total / $perPage), 1);

        if($this->currentPage > $this->lastPage){
            $this->items = [];
        }

        $this->from = $this->currentPage > 1 ? ($this->currentPage - 1) * $this->perPage + 1 : 1;
        $this->to = min($this->currentPage * $this->perPage, $this->total);

    }

    public static function fromQueryBuilder(QueryBuilder $queryBuilder, int $perPage = 15, int $currentPage = 0, $page='page'): self
    {
        $query = clone $queryBuilder;
        
        $query->setFirstResult(($currentPage - 1) * $perPage)
              ->setMaxResults($perPage);

        $paginator = new Paginator($query, true);
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



    private function url(int $page): string
    {
        if ($page < 1 || $page > $this->lastPage) {
            throw new \InvalidArgumentException('Page number out of range');
        }

        $queryParams = $this->queryParams;
        $queryParams[$this->pageName] = $page;

        return $this->path . '?' . http_build_query($queryParams);
    }
}