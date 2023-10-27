<?php

declare(strict_types=1);

namespace Adapter;

use Domain\Visitor;
use Infrastructure\Logger\AppLogger;
use UseCase\RecordVisitorView;

readonly class BannerAdapter
{
    public function __construct(
        private RecordVisitorView $recordVisitorView
    ) {
    }

    public function handleRequest(): void
    {
        $path = $_SERVER['REQUEST_URI'];
        AppLogger::getInstance()->info('Handling request', ['path' => $path]);
        if ($path === '/index1.html' || $path === '/index2.html') {
            $this->serveHtmlFile($path);
        } elseif ($path === '/index.php') {
            $this->recordVisitorView();
        } else {
            http_response_code(404);
            echo 'Page not found';
        }
    }

    private function serveHtmlFile(string $path): void
    {
        $filePath = __DIR__ . $path;
        AppLogger::getInstance()->info('Serving HTML', ['path' => $path]);

        if (file_exists($filePath)) {
            echo file_get_contents($filePath);
        } else {
            http_response_code(404);
            echo 'Page not found';
        }
    }

    private function recordVisitorView(): void
    {
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $viewDate = date('Y-m-d H:i:s');
        $pageUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        AppLogger::getInstance()->info('Recording visitor', ['ip' => $ipAddress]);

        $visitor = new Visitor($ipAddress, $userAgent, $viewDate, $pageUrl, 0);

        $this->recordVisitorView->execute($visitor);
        AppLogger::getInstance()->info('Serving image', ['path' => 'image.png']);

        // Output the image
        header("Content-Type: image/png");
        readfile("image.png");
    }
}
