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
        
            <h1>Tarefa: <?php echo htmlentities($tarefa->getNome()); ?></h1>

            <p>
                <a href="index.php?rota=tarefas">
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
                                <a href="index.php?rota=remover_anexo&id=<?php echo $anexo->getId(); ?>">Remover</a>
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
        
        <script src="../vendor/components/jquery/jquery.min.js"></script>
        <script src="../vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>

    </body>
</html>