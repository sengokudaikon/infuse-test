<?php

namespace Repository;

use Domain\Visitor;

interface VisitorRepositoryInterface
{
    public function find(string $ipAddress, string $userAgent, string $pageUrl): ?Visitor;
    public function insert(Visitor $visitor): void;
    public function update(Visitor $visitor): void;
}
