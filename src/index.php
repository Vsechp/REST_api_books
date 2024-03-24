<?php
require '../vendor/autoload.php';
use Firebase\JWT\JWT;

$dotenv = Dotenv\Dotenv::createImmutable('/var/www/');
$dotenv->load();


$dbPort = $_ENV['DB_PORT'];
$db = new PDO("pgsql:host=db;port={$dbPort};dbname={$_ENV['DB_NAME']}", $_ENV['DB_USER'], $_ENV['DB_PASS']);;
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($method == 'POST' && $path == '/register') {
    $data = json_decode(file_get_contents('php://input'), true);
    $email = $data['email'];
    $password = password_hash($data['password'], PASSWORD_BCRYPT);

    $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user) {
        echo 'User with this email already exists';
        http_response_code(400);
    } else {

        $stmt = $db->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
        $stmt->execute(['email' => $email, 'password' => $password]);

        echo 'User registered successfully';
        http_response_code(200);
    }


} elseif ($method == 'POST' && $path == '/login') {

    $data = json_decode(file_get_contents('php://input'), true);
    $email = $data['email'];
    $password = $data['password'];

    $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();


    if (!$user) {
        echo 'User not found';
        http_response_code(401);
    } elseif (!password_verify($password, $user['password'])) {
        echo 'Invalid password';
        http_response_code(401);
    } else {
        $secret = $_ENV['JWT_SECRET'];
        $token = JWT::encode(['id' => $user['id'], 'email' => $user['email']], $secret);
        echo json_encode(['token' => $token]);
        http_response_code(200);
    }

} elseif ($method == 'GET' && $path == '/books') {
    $authHeader = isset($_SERVER['HTTP_AUTHORIZATION']) ? $_SERVER['HTTP_AUTHORIZATION'] : '';
    $jwt = str_replace('Bearer ', '', $authHeader);

    if (!$jwt) {
        echo 'Missing token';
        http_response_code(401);
        exit();
    }

    try {
        JWT::decode($jwt, $_ENV['JWT_SECRET'], ['HS256']);
    } catch (Exception $e) {
        echo 'Invalid token';
        http_response_code(401);
        exit();
    }

    $stmt = $db->query("SELECT * FROM books");
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($books);
    http_response_code(200);

} else {
    echo 'Not found';
    http_response_code(404);
}

