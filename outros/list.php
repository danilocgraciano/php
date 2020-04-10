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
            
                <?php foreach ($lista_tarefas as $task) : ?>
                    <tr>
                        <td><?php echo $task['nome']; ?></td>
                        <td><?php echo $task['descricao']; ?></td>
                        <td><?php echo traduz_data_para_exibir($task['prazo']); ?></td>
                        <td><?php echo traduzir_prioridade($task['prioridade']); ?></td>
                        <td><?php echo traduzir_concluida($task['concluida']); ?></td>
                        <td>
                            <a href="editar.php?id=<?php echo $task['id']; ?>">Editar</a>
                            <a href="remover.php?id=<?php echo $task['id']; ?>">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach?>

            </table>