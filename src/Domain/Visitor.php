<?php

declare(strict_types=1);

namespace Domain;

class Visitor
{
    public function __construct(
        public string $ipAddress,
        public string $userAgent,
        public string $viewDate,
        public string $pageUrl,
        public int $viewsCount
    )
    {
    }
}
