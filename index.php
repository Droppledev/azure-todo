<?php
$host = "droppledev.database.windows.net";
$user = "droppledev";
$pass = "testAzure19";
$db = "todosimple";
$table_name = "todo_table";

try {
    $conn = new PDO("sqlsrv:server = $host; Database = $db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo "Failed: " . $e;
}
if (isset($_POST['add'])) {
    try {
        $todo = $_POST['todo'];
        // Insert data
        $sql_insert = "INSERT INTO $table_name (todo) VALUES (?)";
        $stmt = $conn->prepare($sql_insert);
        $stmt->bindValue(1, $todo);
        $stmt->execute();
    } catch (Exception $e) {
        echo "Failed: " . $e;
    }
} else if (isset($_POST['delete'])) {
    try {
        $id = $_POST['id'];
        $sql_delete = "DELETE FROM $table_name WHERE id = ?";
        $stmt = $conn->prepare($sql_delete);
        $stmt->bindValue(1, $id);
        $stmt->execute();
    } catch (Exception $e) {
        echo "Failed: " . $e;
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <title>Simple Todo</title>
</head>

<body>
    <div class="container">
        <div class="d-flex justify-content-center">
            <h1 class="display-1 ">Simple Todo</h1>
        </div>
        <div class="d-flex justify-content-center">
            <form class="form-inline mb-3" action="" method="post">
                <input class="form-control mr-3" type="text" name="todo" id="todo" placeholder="Type your todo here...">
                <button class="btn btn-primary" type="submit" name="add"><i class="fas fa-plus"></i></button>
            </form>
        </div>
        <div class="d-flex justify-content-center">

            <table class="table col-md-4">
                <tbody>
                    <?php
                    try {
                        $sql_select = "SELECT * FROM $table_name";
                        $stmt = $conn->query($sql_select);
                        $todos = $stmt->fetchAll();
                        if (count($todos) > 0) {
                            foreach ($todos as $todo) {
                                ?>
                                <tr>
                                    <td class="text-center"><?= $todo['todo'] ?></td>
                                    <td class="text-center">
                                        <form action="" method="post">
                                            <input type="hidden" name="id" value="<?= $todo['id'] ?>">
                                            <button class="btn btn-danger" type="submit" name="delete"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php
                        }
                    } else {
                        echo "<h3>Todo list is empty !</h3>";
                    }
                } catch (Exception $e) {
                    echo "Failed: " . $e;
                }
                ?>
                    <!-- <td>Todo 1</td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="id" value="">
                                <button class="btn btn-danger" type="submit" name="delete"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td>Todo 2</td>
                        <td><button class="btn btn-danger" type="submit"><i class="fas fa-trash"></i></button></td>
                    </tr> -->
                </tbody>
            </table>
        </div>


        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </div>
</body>

</html>