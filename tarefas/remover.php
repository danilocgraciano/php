<?php

    require "config.php";
    require "database.php";

    remover_tarefa($conn, $_GET['id']);

    header('Location: tarefas.php');