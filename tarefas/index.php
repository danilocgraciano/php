<?php

    require "config.php";
    require "helpers/database.php";
    require "helpers/tarefas_helper.php";
    require "models/Tarefa.php";
    require "models/Anexo.php";
    require "models/RepositorioAnexos.php";
    require "models/RepositorioTarefas.php";

    $repositorio_anexos = new RepositorioAnexos($pdo);
    $repositorio_tarefas = new RepositorioTarefas($pdo, $repositorio_anexos);

    $rota = "tarefas";

    if (array_key_exists("rota", $_GET)) {
        $rota = (string) $_GET["rota"];
    }

    if (is_file("controllers/{$rota}.php")) {
        require "controllers/{$rota}.php";
    } else {
        echo "Rota não encontrada";
    }