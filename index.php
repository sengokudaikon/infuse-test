<?php
declare(strict_types=1);

require_once 'vendor/autoload.php';

use Adapter\BannerAdapter;
use Infrastructure\Repository\VisitorRepository;
use UseCase\RecordVisitorView;

// Database connection
$servername = "db";
$username = "admin";
$password = "password";
$dbname = "db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$visitorRepository = new VisitorRepository($conn);
$recordVisitorView = new RecordVisitorView($visitorRepository);
$bannerAdapter = new BannerAdapter($recordVisitorView);

$bannerAdapter->handleRequest();

$conn->close();
