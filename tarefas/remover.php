<?php

    require "config.php";
    require "database.php";
    require "classes/Tarefa.php";
    require "classes/Anexo.php";
    require "classes/RepositorioAnexos.php";
    require "classes/RepositorioTarefas.php";

    $repositorio_anexos = new RepositorioAnexos($pdo);
    $repositorio_tarefas = new RepositorioTarefas($pdo, $repositorio_anexos);

    $repositorio_tarefas->remover($_GET['id']);

    header('Location: tarefas.php');