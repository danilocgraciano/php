<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Gerenciador de Tarefas</title>
        <link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container mt-3">
        
            <h1>Gerenciador de Tarefas</h1>

            <?php if ($exibir_tabela):?>
                <?php require "list.php"; ?>
                <br>
            <?php endif; ?>

            <?php require "form.php"; ?>

        </div>
        
        <script src="../vendor/components/jquery/jquery.min.js"></script>
        <script src="../vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>

    </body>
</html>