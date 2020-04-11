<?php

    require "config.php";
    require "database.php";

    $anexo = buscar_anexo($conn, $_GET["id"]);
    remover_anexo($conn, $anexo["id"]);
    unlink('anexos/' . $anexo["arquivo"]);

    header('Location: tarefa.php?id=' . $anexo["tarefa_id"]);