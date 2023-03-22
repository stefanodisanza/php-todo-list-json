<?php
    $todos = json_decode(file_get_contents('todos.json'), true);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        $newTodo = array(
            "id" => count($todos) + 1,
            "text" => $data['text'],
            "completed" => false
        );
        array_push($todos, $newTodo);
        file_put_contents('todos.json', json_encode($todos));
    }

    header('Content-Type: application/json');
    echo json_encode($todos);
