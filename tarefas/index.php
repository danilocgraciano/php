<?php

    require "vendor/autoload.php";

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    require "config.php";
    require "helpers/database.php";
    require "helpers/tarefas_helper.php";

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