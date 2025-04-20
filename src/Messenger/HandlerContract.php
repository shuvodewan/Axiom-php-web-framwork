<?php

namespace Axiom\Messenger;

interface HandlerContract
{
    public function __invoke($job);
}