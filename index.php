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
    // Database connection
    $servername = "localhost";
    $username = "username";
    $password = "password";
    $database = "todolist";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Display ToDo List items
    $sql = "SELECT * FROM todoitems";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo '<div class="todo-item">';
            echo '<span>' . $row["Title"] . ' - ' . $row["Description"] . '</span>';
            echo '<span class="remove-button" onclick="removeItem(' . $row["ItemNum"] . ')">X</span>';
            echo '</div>';
        }
    } else {
        echo "No to do list items exist yet.";
    }

    $conn->close();
    ?>

    <form action="add_item.php" method="post">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" maxlength="20"><br>
        <label for="description">Description:</label><br>
        <input type="text" id="description" name="description" maxlength="50"><br><br>
        <input type="submit" value="Add">
    </form>

    <script>
        function removeItem(itemId) {
            if (confirm("Are you sure you want to remove this item?")) {
                window.location.href = "remove_item.php?id=" + itemId;
            }
        }
    </script>
</body>
</html>
