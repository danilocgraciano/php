<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Gerenciador de Tarefas</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>
    <body>
        <div class="container mt-3">
        
            <h1>Tarefa: <?php echo htmlentities($tarefa->getNome()); ?></h1>

            <p>
                <a href="tarefas.php">
                    Voltar para a lista de tarefas
                </a>
            </p>
            <p>
                <strong>Concluída:</strong>
                <?php echo traduzir_concluida($tarefa->getConcluida()); ?>
            </p>
            <p>
                <strong>Descrição:</strong>
                <?php echo nl2br(htmlentities($tarefa->getDescricao())); ?>
            </p>
            <p>
                <strong>Prazo:</strong>
                <?php echo traduz_data_para_exibir($tarefa->getPrazo()); ?>
            </p>
            <p>
                <strong>Prioridade:</strong>
                <?php echo traduzir_prioridade($tarefa->getPrioridade()); ?>
            </p>

            <h2>Anexos</h2>

            <?php if (count($tarefa->getAnexos()) > 0) : ?>
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Arquivo</th>
                            <th scope="col">Opções</th>
                        </tr>
                    </thead>

                    <?php foreach ($tarefa->getAnexos() as $anexo) : ?>
                        <tr>
                            <td><?php echo htmlentities($anexo->getNome()); ?></td>
                            <td>
                                <a href="anexos/<?php echo $anexo->getArquivo(); ?>">Download</a>
                                <a href="remover_anexo.php?id=<?php echo $anexo->getId(); ?>">Remover</a>
                            </td>
                        </tr>
                    <?php endforeach?>

                </table>
            <?php else: ?>
                <p>Não há anexos para esta tarefa</p>
            <?php endif; ?>

            <form action="" method="post" enctype="multipart/form-data">
                <fieldset>
                    <legend>Novo anexo</legend>

                    <input type="hidden" name="tarefa_id" value="<?php echo $tarefa->getId(); ?>"/>

                    <label>
                        <?php if ( $tem_erros & array_key_exists('anexo',$erros_validacao)) : ?>
                            <span class="erro">
                                <?php echo $erros_validacao['anexo']; ?>
                            </span>
                        <?php endif; ?>
                        
                        <input type="file" name="anexo" />
                    </label>

                    <br>

                    <button type="submit" class="btn btn-primary">Cadastrar</button>

                </fieldset>
            </form>
        </div>
        
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    </body>
</html>