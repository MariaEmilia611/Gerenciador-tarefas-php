<?php

// Caminho para o arquivo do banco de dados SQLite
define('DB_FILE', __DIR__ . '/tasks.sqlite');

try {
    // Conecta ao banco de dados SQLite
    $pdo = new PDO('sqlite:' . DB_FILE);

    // Define o modo de erro para lançar exceções em caso de problemas
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Cria a tabela 'tasks' se ela não existir
    $pdo->exec("CREATE TABLE IF NOT EXISTS tasks (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        description TEXT NOT NULL,
        completed INTEGER DEFAULT 0
    )");

} catch (PDOException $e) {
    die("Erro ao conectar ou criar o banco de dados: " . $e->getMessage());
}

?>