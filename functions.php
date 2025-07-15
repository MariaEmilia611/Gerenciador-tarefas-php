<?php

require_once 'db.php'; // Inclui a conexão com o banco de dados

/**
 * Adiciona uma nova tarefa ao banco de dados.
 * @param string $description A descrição da tarefa.
 * @return bool True se a tarefa foi adicionada com sucesso, false caso contrário.
 */
function addTask($description) {
    global $pdo; // Acessa a variável PDO global
    try {
        $stmt = $pdo->prepare("INSERT INTO tasks (description) VALUES (:description)");
        $stmt->bindParam(':description', $description);
        return $stmt->execute();
    } catch (PDOException $e) {
        // Logar o erro ou lidar com ele de outra forma
        return false;
    }
}

/**
 * Retorna todas as tarefas do banco de dados.
 * @return array Um array de objetos de tarefa.
 */
function getTasks() {
    global $pdo;
    try {
        $stmt = $pdo->query("SELECT * FROM tasks ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    } catch (PDOException $e) {
        // Logar o erro
        return [];
    }
}

/**
 * Marca uma tarefa como concluída ou não concluída.
 * @param int $id O ID da tarefa.
 * @param int $completed 1 para concluída, 0 para não concluída.
 * @return bool True se a tarefa foi atualizada com sucesso, false caso contrário.
 */
function toggleTaskCompletion($id, $completed) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("UPDATE tasks SET completed = :completed WHERE id = :id");
        $stmt->bindParam(':completed', $completed);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    } catch (PDOException $e) {
        // Logar o erro
        return false;
    }
}

/**
 * Exclui uma tarefa do banco de dados.
 * @param int $id O ID da tarefa a ser excluída.
 * @return bool True se a tarefa foi excluída com sucesso, false caso contrário.
 */
function deleteTask($id) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    } catch (PDOException $e) {
        // Logar o erro
        return false;
    }
}

?>