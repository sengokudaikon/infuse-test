<?php

declare(strict_types=1);

namespace UseCase;

use Domain\Visitor;
use Repository\VisitorRepositoryInterface;

readonly class RecordVisitorView
{
    public function __construct(
        private VisitorRepositoryInterface $visitorRepository
    ) {}

    public function execute(Visitor $visitor): void
    {
        $existingVisitor = $this->visitorRepository->find($visitor->ipAddress, $visitor->userAgent, $visitor->pageUrl);

        if ($existingVisitor) {
            $existingVisitor->viewDate = $visitor->viewDate;
            $existingVisitor->viewsCount++;
            $this->visitorRepository->update($existingVisitor);
        } else {
            $visitor->viewsCount = 1;
            $this->visitorRepository->insert($visitor);
        }
    }
}
