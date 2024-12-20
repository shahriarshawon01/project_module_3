<?php
$file = 'tasks.json';
$tasks = json_decode(file_get_contents($file), true) ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'add') {
        $taskName = trim($_POST['task']);
        if (!empty($taskName)) {
            $tasks[] = ['name' => htmlspecialchars($taskName), 'done' => false];
        }
    } elseif ($action === 'delete') {
        $index = $_POST['index'];
        if (isset($tasks[$index])) {
            array_splice($tasks, $index, 1);
        }
    } elseif ($action === 'toggle') {
        $index = $_POST['index'];
        if (isset($tasks[$index])) {
            $tasks[$index]['done'] = !$tasks[$index]['done'];
        }
    }
    file_put_contents($file, json_encode($tasks));
    header('Location: index.php');
    exit;
}
