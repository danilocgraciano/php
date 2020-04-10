<?php

    include "database.php";
    include "tarefas_helper.php";

    $tem_erros  = false;
    $erros_validacao = [];

    if (tem_post()){
        $tarefa_id = $_POST["tarefa_id"];

        if (!array_key_exists("anexo", $_FILES)){
            $tem_erros = true;
            $erros_validacao["anexo"] = "Você deve selecionar um arquivo para anexar";
        } else {
            if (tratar_anexo($_FILES["anexo"])){
                $nome = $_FILES["anexo"]["name"];
                $anexo = [
                    "tarefa_id" => $tarefa_id,
                    "nome" => substr($nome,0,-4),
                    "arquivo" => $nome,
                ];
            } else {
                $tem_erros = true;
                $erros_validacao["anexo"] = "Envie anexos nos formator zip ou pdf";
            }
        }

        if (!$tem_erros) {
            gravar_anexo($conn, $anexo);
        }
    }

    $tarefa = buscar_tarefa($conn, $_GET['id']);
    $anexos = buscar_anexos($conn, $_GET['id']);

    include "template_tarefa.php";