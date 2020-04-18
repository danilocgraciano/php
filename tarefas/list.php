<table class="table table-sm table-bordered">
    <thead>
        <tr>
            <th scope="col">Nome</th>
            <th scope="col">Descrição</th>
            <th scope="col">Prazo</th>
            <th scope="col">Prioridade</th>
            <th scope="col">Concluída</th>
            <th scope="col"></th>
        </tr>
    </thead>

    <?php foreach ($tarefas as $task) : ?>
        <tr>
            <td>
                <a href="tarefa.php?id=<?php echo $task->getId(); ?>">
                    <?php echo htmlentities($task->getNome()); ?>
                </a>
            </td>
            <td><?php echo htmlentities($task->getDescricao()); ?></td>
            <td><?php echo traduz_data_para_exibir($task->getPrazo()); ?></td>
            <td><?php echo traduzir_prioridade($task->getPrioridade()); ?></td>
            <td><?php echo traduzir_concluida($task->getConcluida()); ?></td>
            <td>
                <a href="editar.php?id=<?php echo $task->getId(); ?>">Editar</a>
                <a href="remover.php?id=<?php echo $task->getId(); ?>">Excluir</a>
            </td>
        </tr>
    <?php endforeach?>

</table>