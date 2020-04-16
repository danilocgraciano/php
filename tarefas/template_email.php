<h1>Tarefa: <?php echo htmlentities($tarefa->getNome()); ?></h1>

<p>
    <strong>Concluída:</strong>
    <?php echo traduz_concluida($tarefa->getConcluida()); ?>
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
    <?php echo traduz_prioridade($tarefa->getPrioridade()); ?>
</p>

<?php if (count($tarefa->getAnexos()) > 0) : ?>
    <p><strong>Atenção!</strong> Esta tarefa contém anexos!</p>
<?php endif; ?>

<p>Tenha um bom dia!</p>