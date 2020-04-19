<form method="POST">

    <input type="hidden" id="id" name="id" value="<?php echo $tarefa->getId(); ?>">

    <div class="form-group row">
        <label for="nome" class="col-sm-2 col-form-label">Nome</label>
        <div class="col-sm-10">
            <input type="text" class="form-control form-control-sm" id="nome" name="nome" value="<?php echo htmlEntities($tarefa->getNome()); ?>">
            <?php if ($tem_erros && array_key_exists('nome', $errors)) : ?>
                <small id="nomeHelp" class="form-text text-muted">
                    <?php echo $errors['nome'];?>
                </small>
            <?php endif?>
        </div>
    </div>

    <div class="form-group row">
        <label for="descricao" class="col-sm-2 col-form-label">Descrição</label>
        <div class="col-sm-10">
        <textarea class="form-control fomr-control-sm" id="descricao" name="descricao" rows="3"><?php echo htmlEntities($tarefa->getDescricao()); ?></textarea>
        </div>
    </div>

    <div class="form-group row">
        <label for="prazo" class="col-sm-2 col-form-label">Prazo</label>
        <div class="col-sm-10">
            <input type="text" class="form-control form-control-sm" id="prazo" name="prazo" value="<?php echo traduz_data_para_exibir($tarefa->getPrazo()); ?>">
            <?php if ($tem_erros && array_key_exists('prazo', $errors)) : ?>
                <small id="prazoHelp" class="form-text text-muted">
                    <?php echo $errors['prazo'];?>
                </small>
            <?php endif?>
        </div>
    </div>

    <fieldset class="form-group">
        <div class="row">
            
            <legend class="col-form-label col-sm-2 pt-0">Prioridade</legend>

            <div class="col-sm-10">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="prioridade" id="baixa" value="1"
                        <?php echo ($tarefa->getPrioridade() == 1) ? 'checked' : ''; ?>
                    />
                    <label class="form-check-label" for="baixa">
                        Baixa
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="prioridade" id="media" value="2"
                        <?php echo ($tarefa->getPrioridade() == 2) ? 'checked' : ''; ?>/>
                    <label class="form-check-label" for="media">
                        Média
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="prioridade" id="alta" value="3"
                        <?php echo ($tarefa->getPrioridade() == 3) ? 'checked' : ''; ?>
                    />
                    <label class="form-check-label" for="alta">
                        Alta
                    </label>
                </div>
            </div>
        </div>
    </fieldset>

    <div class="form-group row">
        <div class="col-sm-2">Concluída</div>
        <div class="col-sm-10">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="concluida" name="concluida" value="1"
                    <?php echo ($tarefa->getConcluida() == 1) ? 'checked' : ''; ?>/>
                <label class="form-check-label" for="concluida">
                    Concluída
                </label>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-2">Lembrete por e-mail:</div>
        <div class="col-sm-10">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="lembrete" name="lembrete" value="1"/>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-10">
        <button type="submit" class="btn btn-primary"><?php echo ($tarefa->getId() > 0) ? 'Editar' : 'Salvar'; ?></button>
    </div>
</form>