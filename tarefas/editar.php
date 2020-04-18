<?php

    require "config.php";
    require "database.php";
    require "tarefas_helper.php";
    require "classes/Tarefa.php";
    require "classes/Anexo.php";
    require "classes/RepositorioAnexos.php";
    require "classes/RepositorioTarefas.php";

    $repositorio_anexos = new RepositorioAnexos($pdo);
    $repositorio_tarefas = new RepositorioTarefas($pdo, $repositorio_anexos);

    $exibir_tabela = false;

    $tem_erros = false;
    $errors = [];
    
    $tarefa = new Tarefa();
    if (tem_post()) {

        $tarefa->setId($_POST['id']);

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
            $tarefa->setPrazo('');
        }

        $tarefa->setPrioridade($_POST['prioridade']);

        if (array_key_exists('concluida' ,$_POST)) {
            $tarefa->setConcluida(1);
        } else {
            $tarefa->setConcluida(0);
        }

        if (!$tem_erros){
            $repositorio_tarefas->atualizar($tarefa);

            if (array_key_exists('lembrete',$_POST) && $_POST["lembrete"] == 1){
                enviar_email($tarefa);
            }

            header('Location: tarefas.php');
            die();
        }

    }

    $tarefa = $repositorio_tarefas->buscar($_GET['id']);

    require "template.php";