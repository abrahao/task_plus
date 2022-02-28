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
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group p-5 text-center bg-light">
                Task <input type="text" name="task" value="<?php echo $task; ?> " size="50" maxlength="70">
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
                    <th scope="col">Task</th>
                    <th scope="col">Start</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>3</th>
                    <td>Larry the Bird</td>
                    <td>
                        <button type="button" class="btn btn-success">Resolvido</button>
                        <button type="button" class="btn btn-danger">Excluir</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>