<?php

declare(strict_types=1);

namespace Infrastructure\Repository;

use Domain\Visitor;
use Infrastructure\Logger\AppLogger;
use Repository\VisitorRepositoryInterface;

readonly class VisitorRepository implements VisitorRepositoryInterface
{
    public function __construct(
        private \mysqli $conn
    ) {
    }

    public function find(string $ipAddress, string $userAgent, string $pageUrl): ?Visitor
    {
        AppLogger::getInstance()->info('Finding visitor', [
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'page_url' => $pageUrl,
        ]);
        $stmt = $this->conn->prepare(
            "SELECT * FROM visitor_info WHERE ip_address = ? AND user_agent = ? AND page_url = ?"
        );
        $stmt->bind_param("sss", $ipAddress, $userAgent, $pageUrl);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new Visitor(
                $row['ip_address'],
                $row['user_agent'],
                $row['view_date'],
                $row['page_url'],
                $row['views_count']
            );
        }

        return null;
    }

    /**
     * @throws \Exception
     */
    public function insert(Visitor $visitor): void
    {
        AppLogger::getInstance()->info('Inserting visitor', [
            'ip_address' => $visitor->ipAddress,
            'user_agent' => $visitor->userAgent,
            'page_url' => $visitor->pageUrl,
        ]);
        $this->conn->begin_transaction();
        try {
            $stmt = $this->conn->prepare(
                "INSERT INTO visitor_info (ip_address, user_agent, view_date, page_url, views_count) VALUES (?, ?, ?, ?, ?)"
            );
            $stmt->bind_param(
                "ssssi",
                $visitor->ipAddress,
                $visitor->userAgent,
                $visitor->viewDate,
                $visitor->pageUrl,
                $visitor->viewsCount
            );
            $stmt->execute();

            $this->conn->commit();
        } catch (\Exception $e) {
            $this->conn->rollback();
            throw $e;
        }
    }

    /**
     * @throws \Exception
     */
    public function update(Visitor $visitor): void
    {
        AppLogger::getInstance()->info('Updating visitor', [
            'ip_address' => $visitor->ipAddress,
            'user_agent' => $visitor->userAgent,
            'page_url' => $visitor->pageUrl,
        ]);
        $this->conn->begin_transaction();
        try {
            $stmt = $this->conn->prepare(
                "INSERT INTO visitor_info (ip_address, user_agent, view_date, page_url, views_count) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE view_date = VALUES(view_date), views_count = views_count + 1"
            );
            $stmt->bind_param(
                "ssssi",
                $visitor->ipAddress,
                $visitor->userAgent,
                $visitor->viewDate,
                $visitor->pageUrl,
                $visitor->viewsCount
            );
            $stmt->execute();

            $this->conn->commit();
        } catch (\Exception $e) {
            $this->conn->rollback();
            throw $e;
        }
    }
}
