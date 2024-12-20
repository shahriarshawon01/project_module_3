<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do App</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Simple To-Do App</h1>
        <form action="task.php" method="POST">
            <input type="text" name="task" placeholder="Enter your task" required>
            <button type="submit" name="action" value="add">Add Task</button>
        </form>
        <ul class="task-list">
            <?php
            $tasks = json_decode(file_get_contents('tasks.json'), true);
            if (!empty($tasks)) {
                foreach ($tasks as $index => $task) {
                    $status = $task['done'] ? 'done' : '';
                    echo "<li class='$status'>
                            <span onclick=\"markTask($index)\">" . htmlspecialchars($task['name']) . "</span>
                            <form action='task.php' method='POST' class='inline-form'>
                                <input type='hidden' name='index' value='$index'>
                                <button type='submit' name='action' value='delete'>Delete</button>
                            </form>
                          </li>";
                }
            }
            ?>
        </ul>
    </div>

    <script>
        function markTask(index) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'task.php';

            const inputIndex = document.createElement('input');
            inputIndex.type = 'hidden';
            inputIndex.name = 'index';
            inputIndex.value = index;

            const action = document.createElement('input');
            action.type = 'hidden';
            action.name = 'action';
            action.value = 'toggle';

            form.appendChild(inputIndex);
            form.appendChild(action);

            document.body.appendChild(form);
            form.submit();
        }
    </script>
</body>

</html>