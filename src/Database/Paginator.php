<?php

namespace Axiom\Database;

use Axiom\Facade\Url;
use Axiom\Http\Request;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;

/**
 * Paginator Class
 *
 * A robust pagination handler that works with Doctrine QueryBuilder,
 * providing metadata and URL generation for paginated results.
 */
class Paginator
{
    /** @var array The items for the current page */
    private array $items = [];

    /** @var int Total number of items across all pages */
    private int $total;

    /** @var int Number of items per page */
    private int $perPage;

    /** @var int Current page number */
    private int $currentPage;

    /** @var int Last available page number */
    private int $lastPage;

    /** @var string The query string parameter used for pagination */
    private string $pageName;

    /** @var int The index of the first item on current page */
    private int $from = 0;

    /** @var int The index of the last item on current page */
    private int $to = 0;

    /** @var array Additional query parameters to include in URLs */
    private array $queryParams = [];

    /** @var Request The HTTP request instance */
    private Request $request;

    /**
     * Constructor.
     *
     * @param mixed $items The paginated items (array or iterable)
     * @param int $total Total number of items
     * @param int $perPage Items per page
     * @param int $currentPage Current page number
     * @param string $page The query parameter name for pagination
     */
    public function __construct($items, int $total, int $perPage, int $currentPage, string $page)
    {
        $this->request = Request::getInstance();
        $this->setProperties($items, $total, $perPage, $currentPage, $page);
    }

    /**
     * Set pagination properties.
     *
     * @param mixed $items The paginated items
     * @param int $total Total number of items
     * @param int $perPage Items per page
     * @param int $currentPage Current page number
     * @param string $page The query parameter name for pagination
     */
    public function setProperties($items, int $total, int $perPage, int $currentPage, string $page): void
    {
        $this->total = $total;
        $this->pageName = $page;
        $this->perPage = $perPage;
        $this->currentPage = $currentPage ?? $this->request->getQuery($page);
        $this->lastPage = max((int) ceil($total / $perPage), 1);

        if ($this->currentPage <= $this->lastPage) {
            $this->items = is_array($items) ? $items : iterator_to_array($items);
            $this->from = $this->currentPage > 1 ? ($this->currentPage - 1) * $this->perPage + 1 : 1;
            $this->to = min($this->currentPage * $this->perPage, $this->total);
        }
    }

    /**
     * Create a Paginator instance from a QueryBuilder.
     *
     * @param QueryBuilder $queryBuilder The Doctrine QueryBuilder instance
     * @param int $perPage Items per page
     * @param int $currentPage Current page number
     * @param string $page The query parameter name for pagination
     * @return self
     */
    public static function fromQueryBuilder(QueryBuilder $queryBuilder, int $perPage = 15, int $currentPage = 0, string $page = 'page'): self
    {
        $query = clone $queryBuilder;
        
        $query->setFirstResult(($currentPage - 1) * $perPage)
              ->setMaxResults($perPage);

        $paginator = new DoctrinePaginator($query, true);
        $total = count($paginator);
        $results = iterator_to_array($paginator);

        return new self($results, $total, $perPage, $currentPage, $page);
    }

    /* Getters */

    /**
     * Get the items for the current page.
     *
     * @return array
     */
    public function items(): array
    {
        return $this->items;
    }

    /**
     * Get the total number of items.
     *
     * @return int
     */
    public function total(): int
    {
        return $this->total;
    }

    /**
     * Get the number of items per page.
     *
     * @return int
     */
    public function perPage(): int
    {
        return $this->perPage;
    }

    /**
     * Get the current page number.
     *
     * @return int
     */
    public function currentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * Get the last available page number.
     *
     * @return int
     */
    public function lastPage(): int
    {
        return $this->lastPage;
    }

    /**
     * Get the index of the first item on current page.
     *
     * @return int
     */
    public function from(): int
    {
        return $this->from;
    }

    /**
     * Get the index of the last item on current page.
     *
     * @return int
     */
    public function to(): int
    {
        return $this->to;
    }

    /**
     * Check if there are more pages available.
     *
     * @return bool
     */
    public function hasMorePages(): bool
    {
        return $this->currentPage < $this->lastPage;
    }

    /* Additional methods */

    /**
     * Get the index of the first item on current page (alias of from()).
     *
     * @return int|null Returns null if no items
     */
    public function firstItem(): ?int
    {
        return $this->total > 0 ? $this->from : null;
    }

    /**
     * Get the index of the last item on current page (alias of to()).
     *
     * @return int|null Returns null if no items
     */
    public function lastItem(): ?int
    {
        return $this->total > 0 ? $this->to : null;
    }

    /**
     * Check if the paginator is empty.
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    /**
     * Check if the paginator is not empty.
     *
     * @return bool
     */
    public function isNotEmpty(): bool
    {
        return !$this->isEmpty();
    }

    /**
     * Append additional query parameters to pagination URLs.
     *
     * @param array $params Key-value pairs to append
     * @return void
     */
    public function append(array $params = []): void
    {
        $this->queryParams = $params;
    }

    /**
     * Generate a URL for a given page number.
     *
     * @param int $page Page number
     * @return string Generated URL
     */
    private function url(int $page): string
    {
        $queryParams = $this->queryParams;
        $queryParams[$this->pageName] = $page;

        return Url::to(parameters: $queryParams);
    }

    /**
     * Get pagination metadata.
     *
     * @return array Contains:
     *               - current_page
     *               - from (first item index)
     *               - last_page
     *               - per_page
     *               - to (last item index)
     *               - total
     *               - path (base URL)
     */
    public function meta(): array
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

    /**
     * Get pagination links.
     *
     * @return array Contains:
     *               - first (URL to first page)
     *               - last (URL to last page)
     *               - prev (URL to previous page or null)
     *               - next (URL to next page or null)
     */
    public function links(): array
    {
        return [
            'first' => $this->url(1),
            'last' => $this->url($this->lastPage()),
            'prev' => $this->currentPage() > 1 ? $this->url($this->currentPage() - 1) : null,
            'next' => $this->hasMorePages() ? $this->url($this->currentPage() + 1) : null,
        ];
    }

    /**
     * Convert the paginator to an array representation.
     *
     * @return array Contains:
     *               - data (the paginated items)
     *               - meta (pagination metadata)
     *               - links (pagination URLs)
     */
    public function toArray(): array
    {
        return [
            'data' => $this->items(),
            'meta' => $this->meta(),
            'links' => $this->links(),
        ];
    }
}