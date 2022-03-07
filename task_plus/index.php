<?php
$taskErr = "";
$task = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["task"])) {
        $taskErr = "task is required";
    } else {
        $task = test_input($_POST["task"]);
        // check if task only contains letters and whitespace

    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Task</title>
</head>

<nav class="navbar col-12 position-fixed navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">
        <h2>Task Management</h2>
    </a>
</nav>
<div class="container-fluid p-5">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group p-5 text-center bg-light">
            Task <input type="text" name="task" value="<?php
                if (isset($dados['task'])) {
                    echo $dados['task'];
                }?>" size="50" maxlength="70">
            <span class="error"> <?php echo $taskErr; ?></span>

            <input type="submit" name="submit" value="Add">
        </div>
    </form>

</div>
<div class="jumbotron p-5">
    <?php
    include_once "./Connection.php";
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    //Verificar se o usuário clicou no botão
    if (!empty($dados['submit'])) {
        //var_dump($dados);

        $empty_input = false;

        $dados = array_map('trim', $dados);
        if (in_array("", $dados)) {
            $empty_input = true;
            echo "<p style='color: #f00;'>Erro: Necessário preencher todos campos!</p>";
        }
        if (!$empty_input) {
            try {
                $stmt = $conn->prepare("INSERT INTO tasks (task) VALUES (:task) ");
                // $stmt = $conn->prepare($query_task);
                $stmt->bindParam(':task', $dados['task']);
                $stmt->execute();

                echo "<p style='color: green;'>Tarefa cadastrada!</p>";
            } catch (PDOException $e) {
                echo "Erro" . $e->getMessage();
            }
        }
    }
    ?>
    <!-- <h3>Tasks</h3> -->
    <table class="table table-hover table-dark">
        <thead>
            <tr>
                <th>ID</th>
                <th>Task</th>
                <th>Start</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include_once "./Connection.php";
            
            $sql = 'SELECT * FROM tasks ORDER BY id';
            foreach ($conn->query($sql) as $row) {
                // print $row['task'] . "\t";
            ?>

                <?php
                $date = $row['data_cad'];

                // Create the timestamp from the given date
                $timestamp = strtotime($date);

                // Create the new format from the timestamp
                $date = date("d/m/Y", $timestamp);
                ?>

                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['task'] ?></td>
                    <td><?= $date ?></td>
                    <td>
                        <button type="button" class="btn btn-success" id="" value="">Resolvido</button>
                        <button type="button" class="btn btn-danger" id="excluir" value="<?=$row['id']?>">Excluir</button>

                    <!-- Implementação do Delete. Falta terminar -->
                        <?php
                        include_once "./Connection.php";
                        try{    
                        
                        $sql = "DELETE FROM tasks WHERE id = ?";
                            $conn->exec($sql);

                            echo "Deletado!";
                        }catch(PDOException $e){
                            echo $sql . "<br>" . $e->getMessage();
                        }
                        ?>

                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>

</div>