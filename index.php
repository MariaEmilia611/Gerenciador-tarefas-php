<?php
require_once 'functions.php'; // Inclui as funções do gerenciador

// Lógica para lidar com as requisições (adicionar, concluir, excluir)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_task']) && !empty($_POST['description'])) {
        addTask($_POST['description']);
    } elseif (isset($_POST['toggle_completion']) && isset($_POST['task_id']) && isset($_POST['completed'])) {
        toggleTaskCompletion($_POST['task_id'], (int)$_POST['completed']);
    } elseif (isset($_POST['delete_task']) && isset($_POST['task_id'])) {
        deleteTask($_POST['task_id']);
    }
    // Redireciona para evitar reenvio do formulário ao recarregar a página
    header('Location: index.php');
    exit();
}

$tasks = getTasks(); // Busca todas as tarefas para exibir
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Tarefas PHP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Meu Gerenciador de Tarefas</h1>

        <form action="index.php" method="POST" class="add-task-form">
            <input type="text" name="description" placeholder="Adicionar nova tarefa..." required>
            <button type="submit" name="add_task">Adicionar</button>
        </form>

        <ul class="task-list">
            <?php if (empty($tasks)): ?>
                <li class="no-tasks">Nenhuma tarefa por enquanto!</li>
            <?php else: ?>
                <?php foreach ($tasks as $task): ?>
                    <li class="<?= $task->completed ? 'completed' : '' ?>">
                        <span><?= htmlspecialchars($task->description) ?></span>
                        <div class="actions">
                            <form action="index.php" method="POST" style="display: inline;">
                                <input type="hidden" name="task_id" value="<?= $task->id ?>">
                                <input type="hidden" name="completed" value="<?= $task->completed ? 0 : 1 ?>">
                                <button type="submit" name="toggle_completion">
                                    <?= $task->completed ? 'Desmarcar' : 'Concluir' ?>
                                </button>
                            </form>
                            <form action="index.php" method="POST" style="display: inline;">
                                <input type="hidden" name="task_id" value="<?= $task->id ?>">
                                <button type="submit" name="delete_task" class="delete-btn">Excluir</button>
                            </form>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
</body>
</html>