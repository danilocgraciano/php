<?php

    require "config.php";
    require "database.php";
    require "classes/Tarefa.php";
    require "classes/Anexo.php";
    require "classes/RepositorioAnexos.php";
    require "classes/RepositorioTarefas.php";

    $repositorio_anexos = new RepositorioAnexos($conn);
    $repositorio_tarefas = new RepositorioTarefas($conn, $repositorio_anexos);

    $repositorio_tarefas->remover($_GET['id']);

    header('Location: tarefas.php');