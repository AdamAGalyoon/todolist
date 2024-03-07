<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDo List</title>
    <style>
        .todo-item {
            margin-bottom: 10px;
        }
        .remove-button {
            color: red;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>ToDo List</h1>

    <?php

$host = 'localhost';
$dbname = 'todolist';
$username = 'root';
$password = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$todolist", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: Could not connect. " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['title']) && isset($_POST['description'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        
        $stmt = $pdo->prepare("INSERT INTO todoitems (Title, Description) VALUES (?, ?)");
        $stmt->execute([$title, $description]);
        
        header("Location: index.php");
        exit();
    }
}

$stmt = $pdo->query("SELECT * FROM todoitems");
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>ToDo List</h1>
    <?php if (count($items) > 0): ?>
        <ul>
            <?php foreach ($items as $item): ?>
                <li>
                    <?php echo $item['Title']; ?> - <?php echo $item['Description']; ?>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="item_id" value="<?php echo $item['ItemNum']; ?>">
                        <button type="submit" style="color: red;">X</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No to do list items exist yet.</p>
    <?php endif; ?>

    <h2>Add New Item</h2>
    <form method="post">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" maxlength="20" required><br>
        <label for="description">Description:</label>
        <input type="text" id="description" name="description" maxlength="50" required><br>
        <button type="submit">Add</button>
    </form>
</body>
</html>
