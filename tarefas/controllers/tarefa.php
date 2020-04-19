<?php

    $tem_erros  = false;
    $erros_validacao = [];

    if (tem_post()){
        $tarefa_id = $_POST["tarefa_id"];
        $anexo = new Anexo();

        if (!array_key_exists("anexo", $_FILES)){
            $tem_erros = true;
            $erros_validacao["anexo"] = "Você deve selecionar um arquivo para anexar";
        } else {
            $dados_anexo = $_FILES["anexo"];
            if (tratar_anexo($dados_anexo)){
                $anexo->setTarefaId($tarefa_id);
                $anexo->setNome(substr($dados_anexo['name'],0,-4));
                $anexo->setArquivo($dados_anexo['name']);
            } else {
                $tem_erros = true;
                $erros_validacao["anexo"] = "Envie anexos nos formator zip ou pdf";
            }
        }

        if (!$tem_erros) {
            if (strlen($anexo->getArquivo()) > 0){
                $repositorio_anexos->salvar_anexo($anexo);
            }
        }
    }

    $tarefa = $repositorio_tarefas->buscar($_GET['id']);

    include __DIR__ . "/../views/template_tarefa.php";