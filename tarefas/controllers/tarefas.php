<?php
    
    $exibir_tabela = true;

    $tem_erros = false;
    $errors = [];

    $tarefa = new Tarefa();
    $tarefa->setPrioridade(1);

    if (tem_post()) {

        if (array_key_exists('nome', $_POST) && strlen($_POST['nome']) > 0) {
            $tarefa->setNome($_POST['nome']);
        } else {
            $tem_erros = true;
            $errors['nome'] = 'nome inválido';
        }

        if (array_key_exists('descricao', $_POST)) {
            $tarefa->setDescricao($_POST['descricao']);
        } else {
            $tarefa->setDescricao('');
        }

        if (array_key_exists('prazo', $_POST) && strlen($_POST['prazo']) > 0) {
            if (validar_data($_POST['prazo'])){
                $tarefa->setPrazo(traduz_data_para_banco($_POST['prazo']));
            } else {
                $tem_erros = true;
                $errors['prazo'] = 'prazo inválido';
            }
        } else {
            $tem_erros = true;
            $errors['prazo'] = 'prazo inválido';
        }

        $tarefa->setPrioridade($_POST['prioridade']);

        if (array_key_exists('concluida' ,$_POST)) {
            $tarefa->setConcluida(true);
        } else {
            $tarefa->setConcluida(false);
        }

        if (!$tem_erros){
            $repositorio_tarefas->salvar($tarefa);

            if (array_key_exists('lembrete',$_POST) && $_POST["lembrete"] == 1){
                enviar_email($tarefa);
            }

            header('Location: index.php?rota=tarefas');
            die();
        }
    }

    $tarefas = $repositorio_tarefas->buscar();

    require __DIR__ . "/../views/template.php";