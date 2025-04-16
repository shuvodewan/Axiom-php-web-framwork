<?php
namespace Axiom\Exception;

use Axiom\Http\Response;
use Throwable;

interface ExceptionHandlerInterface
{
    public function canHandle(Throwable $e): bool;
    public function handle(Throwable $e): Response;
}