<?php
$taskErr = "";
$task = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["task"])) {
        $taskErr = "task is required";
    } else {
        $task = test_input($_POST["task"]);
        // check if task only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $task)) {
            $taskErr = "Only letters and white space allowed";
        }
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
<div class="container-fluid bg-light p-5">
    <div class="jumbotron">
        <div class=" p-3 my-3 bg-success text-white">
            <h2>Task+</h2>
        </div>


        <?php
        include_once "./conexao.php";
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
                $query_task = "INSERT INTO tasks (task) VALUES (:task) ";
                $cad_task = $conn->prepare($query_task);
                $cad_task->bindParam(':task', $dados['task'], PDO::PARAM_STR);
                $cad_task->execute();
                if ($cad_task->rowCount()) {
                    echo "<p style='color: green;'>Usuário cadastrado com sucesso!</p>";
                    unset($dados);
                } else {
                    echo "<p style='color: #f00;'>Erro: Usuário não cadastrado com sucesso!</p>";
                }
            }
        }
        ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group p-5 text-center bg-light">
                Task <input type="text" name="task" value="<?php
                                                            if (isset($dados['task'])) {
                                                                echo $dados['task'];
                                                            }
                                                            ?>" size="50" maxlength="70">
                <span class="error"> <?php echo $taskErr; ?></span>

                <input type="submit" name="submit" value="Add">
            </div>
            <br>
        </form>
    </div>
    <hr>
    <div class="jumbotron">
        <h3>Tasks</h3>
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
                include_once "./conexao.php";
                $sql = 'SELECT * FROM tasks ORDER BY id';
                foreach ($conn->query($sql) as $row) {
                    // print $row['task'] . "\t";

                ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['task'] ?></td>
                        <td>00:00:00</td>
                        <td>
                            <button type="button" class="btn btn-success">Resolvido</button>
                            <button type="button" class="btn btn-danger">Excluir</button>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>