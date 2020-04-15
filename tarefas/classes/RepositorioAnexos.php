<?php

class RepositorioAnexos
{
    private $conexao;

    public function __construct($conexao)
    {
        $this->conexao = $conexao;
    }

    public function buscar_anexos($tarefa_id)
    {
        $query = "SELECT * FROM anexos WHERE tarefa_id = {$tarefa_id}";
        $resultado = $this->conexao->query($query);

        $anexos = [];

        if (!$resultado){
            error_log("Error " . mysqli_error($this->conexao));
            return $anexos;
        }

        while($anexo = $resultado->fetch_object('Anexo')) {
            $anexos[] = $anexo;
        }

        return $anexos;
    }

    public function buscar_anexo($anexo_id)
    {
        $query = "SELECT * FROM anexos WHERE id = {$anexo_id}";
        $resultado = $this->conexao->query($query);

        $anexo;

        if (!$resultado){
            error_log("Error " . mysqli_error($this->conexao));
            return $anexo;
        }

        $anexo = $resultado->fetch_object('Anexo');
        return $anexo;
    }

    public function salvar_anexo(Anexo $anexo)
    {
        $query = "INSERT INTO anexos (tarefa_id, nome, arquivo) VALUES (
            {$anexo->getTarefaId()},
            '{$anexo->getNome()}',
            '{$anexo->getArquivo()}'
        )";

        $res = $this->conexao->query($query);

        if (!$res){
            error_log("Error " . mysqli_error($this->conexao));
        }
    }

    public function remover_anexo($id)
    {
        $query = "DELETE FROM anexos WHERE id = {$id}";

        $res = $this->conexao->query();

        if (!$res){
            error_log("Error " . mysqli_error($this->conexao));
        }
    }
}