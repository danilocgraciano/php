<?php

    try {
        $pdo = new PDO(getenv("BD_DSN"), getenv("BD_USUARIO"), getenv("BD_SENHA"));
    } catch(PDOException $e) {
        error_log($e->getMessage());
        die();
    }