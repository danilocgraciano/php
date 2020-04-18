<?php

    require "config.php";
    require "database.php";
    require "classes/Tarefa.php";
    require "classes/Anexo.php";
    require "classes/RepositorioAnexos.php";
    require "classes/RepositorioTarefas.php";

    $repositorio_anexos = new RepositorioAnexos($pdo);

    $anexo = $repositorio_anexos->buscar_anexo($_GET["id"]);
    $repositorio_anexos->remover_anexo($anexo->getId());
    unlink('anexos/' . $anexo->getArquivo());

    header('Location: tarefa.php?id=' . $anexo->getTarefaId());