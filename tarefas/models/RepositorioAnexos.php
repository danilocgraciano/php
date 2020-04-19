<?php

class RepositorioAnexos
{
    private $conexao;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function buscar_anexos($tarefa_id)
    {
        $tarefa_id = strip_tags($tarefa_id);
        $query = "SELECT * FROM anexos WHERE tarefa_id = :tarefa_id";
        $stmt = $this->pdo->prepare($query);
        $resultado = $stmt->execute([
            "tarefa_id" => $tarefa_id
        ]);

        $anexos = [];

        if (!$resultado){
            error_log(print_r($stmt->errorInfo(),true));
            return $anexos;
        }

        while ($anexo = $stmt->fetchObject('Anexo')) {
            $anexos[] = $anexo;
        }

        return $anexos;
    }

    public function buscar_anexo($anexo_id)
    {
        $tarefa_id = strip_tags($anexo_id);
        $query = "SELECT * FROM anexos WHERE id = :anexo_id";
        $stmt = $this->pdo->prepare($query);
        $res = $stmt->execute([
            "anexo_id" => $anexo_id
        ]);

        $anexo;

        if (!$res){
            error_log(print_r($this->pdo->errorInfo(),true));
            return $anexo;
        }

        $anexo = $stmt->fetchObject('Anexo');
        return $anexo;
    }

    public function salvar_anexo(Anexo $anexo)
    {
        $query = "INSERT INTO anexos 
        (tarefa_id, nome, arquivo) 
        VALUES (:tarefa_id, :nome, :arquivo)";

        $stmt = $this->pdo->prepare($query);
        $res = $stmt->execute([
            "tarefa_id" => $anexo->getTarefaId(),
            "nome" => strip_tags($anexo->getNome()),
            "arquivo" => strip_tags($anexo->getArquivo())
        ]);

        if (!$res){
            error_log(print_r($this->pdo->errorInfo(),true));
        }
    }

    public function remover_anexo($id)
    {
        $query = "DELETE FROM anexos WHERE id = :id";

        $stmt = $this->pdo->prepare($query);
        $res = $stmt->execute([
            "id" => $id
        ]);

        if (!$res){
            error_log(print_r($this->pdo->errorInfo(),true));
            return $tarefa;
        }
    }
}