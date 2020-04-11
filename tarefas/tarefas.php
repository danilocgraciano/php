<?php
    session_start();
    
    require "config.php";
    require "database.php";
    require "tarefas_helper.php";

    $exibir_tabela = true;

    $tem_erros = false;
    $errors = [];

    $tarefa = [
        'id' => 0,
        'nome' => (array_key_exists('nome', $_POST)) ? $_POST['nome'] : '',
        'descricao' => (array_key_exists('descricao', $_POST)) ? $_POST['descricao'] : '',
        'prazo' => (array_key_exists('prazo', $_POST)) ? traduz_data_para_banco($_POST['prazo']) : '',
        'prioridade' => (array_key_exists('prioridade', $_POST)) ? $_POST['prioridade'] : 1,
        'concluida' => (array_key_exists('concluida', $_POST)) ? $_POST['concluida'] : ''
    ];
    
    if (tem_post()) {

        if (array_key_exists('nome', $_POST) && strlen($_POST['nome']) > 0) {
            $tarefa['nome'] = $_POST['nome'];
        } else {
            $tem_erros = true;
            $errors['nome'] = 'nome inválido';
        }

        if (array_key_exists('descricao', $_POST)) {
            $tarefa['descricao'] = $_POST['descricao'];
        } else {
            $tarefa['descricao'] = '';
        }

        if (array_key_exists('prazo', $_POST) && strlen($_POST['prazo']) > 0) {
            if (validar_data($_POST['prazo'])){
                $tarefa['prazo'] = traduz_data_para_banco($_POST['prazo']);
            } else {
                $tem_erros = true;
                $errors['prazo'] = 'prazo inválido';
            }
        } else {
            $tem_erros = true;
            $errors['prazo'] = 'prazo inválido';
        }

        $tarefa['prioridade'] = $_POST['prioridade'];

        if (array_key_exists('concluida' ,$_POST)) {
            $tarefa['concluida'] = 1;
        } else {
            $tarefa['concluida'] = 0;
        }

        if (!$tem_erros){
            gravar_tarefa($conn, $tarefa);

            if (array_key_exists('lembrete',$_POST) && $_POST["lembrete"] == 1){
                enviar_email($tarefa);
            }

            header('Location: tarefas.php');
            die();
        }
    }

    $lista_tarefas = buscar_tarefas($conn);

    require "template.php";