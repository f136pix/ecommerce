<?php

try {
    $pdo = new PDO(
        "mysql:host=127.0.0.1;dbname=ecommerce",
        "admin",
        "Password!"
    );
    echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
