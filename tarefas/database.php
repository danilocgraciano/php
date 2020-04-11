<?php
    $SERVER = 'localhost';
    $USER = 'admin';
    $PASSWD = 'admin';
    $DATABASE = 'tarefas';

    $conn = mysqli_connect($SERVER, $USER, $PASSWD, $DATABASE);

    if (mysqli_connect_errno($conn)) {
        error_log("Error " . mysqli_connect_error());
        die();
    }

    function buscar_tarefas($conn) {
        $query = "SELECT * FROM tarefas";
        $res = mysqli_query($conn, $query);
        if (!$res){
            error_log("Error " . mysqli_error($conn));
        }

        $tarefas = [];

        while($tarefa = mysqli_fetch_assoc($res)){
            $tarefas[] = $tarefa;
        }

        return $tarefas;
    }

    function gravar_tarefa($conn, $tarefa) {
        $query = "INSERT INTO tarefas (nome, descricao, prioridade, prazo, concluida) values ('{$tarefa['nome']}','{$tarefa['descricao']}','{$tarefa['prioridade']}','{$tarefa['prazo']}',{$tarefa['concluida']})";
        $res = mysqli_query($conn, $query);
        if (!$res){
            error_log("Error " . mysqli_error($conn));
        }
    }

    function buscar_tarefa($conn, $id) {
        $query = "SELECT * FROM tarefas WHERE id = {$id}";
        $res = mysqli_query($conn, $query);
        if (!$res){
            error_log("Error " . mysqli_error($conn));
            return;
        }
        return mysqli_fetch_assoc($res);
    }

    function editar_tarefa($conn, $tarefa) {
        $query = "
            UPDATE tarefas 
                SET nome = '{$tarefa['nome']}',
                descricao = '{$tarefa['descricao']}',
                prioridade = '{$tarefa['prioridade']}',
                prazo = '{$tarefa['prazo']}',
                concluida = '{$tarefa['concluida']}'
            WHERE id = {$tarefa['id']}";

        $res = mysqli_query($conn, $query);
        if (!$res){
            error_log("Error " . mysqli_error($conn));
        }
    }

    function remover_tarefa($conn, $id) {
        $query = "DELETE FROM tarefas WHERE id = {$id}";

        $res = mysqli_query($conn, $query);
        if (!$res){
            error_log("Error " . mysqli_error($conn));
        }
    }

    function gravar_anexo($conn, $anexo){
        $query = "INSERT INTO anexos (tarefa_id, nome, arquivo) VALUES (
            {$anexo['tarefa_id']},
            '{$anexo['nome']}',
            '{$anexo['arquivo']}'
        )";
        $res = mysqli_query($conn, $query);
        if (!$res){
            error_log("Error " . mysqli_error($conn));
        }
    }

    function buscar_anexos($conn, $tarefa_id){
        $query = "SELECT * FROM anexos WHERE tarefa_id = {$tarefa_id}";
        $res = mysqli_query($conn, $query);

        if (!$res){
            error_log("Error " . mysqli_error($conn));
        }

        $anexos = [];

        while($anexo = mysqli_fetch_assoc($res)){
            $anexos[] = $anexo;
        }

        return $anexos;
    }

    function buscar_anexo($conn, $id) {
        $query = "SELECT * FROM anexos WHERE id = {$id}";
        $res = mysqli_query($conn, $query);
        if (!$res){
            error_log("Error " . mysqli_error($conn));
            return;
        }
        return mysqli_fetch_assoc($res);
    }

    function remover_anexo($conn, $id) {
        $query = "DELETE FROM anexos WHERE id = {$id}";

        $res = mysqli_query($conn, $query);
        if (!$res){
            error_log("Error " . mysqli_error($conn));
        }
    }