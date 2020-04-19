<?php

class RepositorioTarefas
{
    private $pdo;
    private $repositorio_anexos;

    public function __construct(PDO $pdo, $repositorio_anexos)
    {
        $this->pdo = $pdo;
        $this->repositorio_anexos = $repositorio_anexos;
    }

    public function salvar(Tarefa $tarefa)
    {
        $prazo = $tarefa->getPrazo();
        
        if (is_object($prazo)) {
            $prazo = $prazo->format('Y-m-d');
        }

        $query = "
            INSERT INTO tarefas 
            (nome, descricao, prioridade, prazo, concluida)
            VALUES
            (:nome, :descricao, :prioridade, :prazo, :concluida)
        ";

        $stmt = $this->pdo->prepare($query);
        $res = $stmt->execute([
            "nome" => strip_tags($tarefa->getNome()),
            "descricao" => strip_tags($tarefa->getDescricao()),
            "prioridade" => $tarefa->getPrioridade(),
            "prazo" => $prazo,
            "concluida" => ($tarefa->getConcluida()) ? 1 : 0
        ]);

        if (!$res){
            error_log(print_r($stmt->errorInfo(),true));
        }
    }

    public function atualizar(Tarefa $tarefa)
    {
        $prazo = $tarefa->getPrazo();

        if (is_object($prazo)) {
            $prazo = $prazo->format('Y-m-d');
        }

        $query = "
            UPDATE tarefas SET
                nome = :nome,
                descricao = :descricao,
                prioridade = :prioridade,
                prazo = :prazo,
                concluida = :concluida
            WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($query);

        $res = $stmt->execute([
            "nome" => strip_tags($tarefa->getNome()),
            "descricao" => strip_tags($tarefa->getDescricao()),
            "prioridade" => $tarefa->getPrioridade(),
            "prazo" => $prazo,
            "concluida" => ($tarefa->getConcluida()) ? 1 : 0,
            "id" => $tarefa->getId(),
        ]);

        if (!$res){
            error_log(print_r($stmt->errorInfo(),true));
        }
    }

    public function buscar($tarefa_id = 0)
    {
        if ($tarefa_id > 0) {
            return $this->buscar_tarefa($tarefa_id);
        } else {
            return $this->buscar_tarefas();
        }
    }

    private function buscar_tarefas()
    {
        $query = 'SELECT * FROM tarefas';
        $resultado = $this->pdo->query($query, PDO::FETCH_CLASS, 'Tarefa');

        $tarefas = [];

        if (!$resultado){
            error_log(print_r($this->pdo->errorInfo(),true));
            return $tarefas;
        }

        foreach($resultado as $tarefa){
            $anexos = $this->repositorio_anexos->buscar_anexos($tarefa->getId()) ?? [];
            $tarefa->setAnexos($anexos);
            $tarefas[] = $tarefa;
        }

        return $tarefas;
    }

    private function buscar_tarefa($tarefa_id)
    {
        $query = "SELECT * FROM tarefas where id = :id";
        $stmt = $this->pdo->prepare($query);
        $res = $stmt->execute([
            "id" => $tarefa_id
        ]);

        $tarefa;

        if (!$res){
            error_log(print_r($this->pdo->errorInfo(),true));
            return $tarefa;
        }

        $tarefa = $stmt->fetchObject('Tarefa');
        $anexos = $this->repositorio_anexos->buscar_anexos($tarefa->getId()) ?? [];
        $tarefa->setAnexos($anexos);

        return $tarefa;
    }

    function remover($tarefa_id)
    {
        $query = "DELETE FROM tarefas where id = :id";
        $stmt = $this->pdo->prepare($query);
        $res = $stmt->execute([
            "id" => $tarefa_id
        ]);

        if (!$res){
            error_log(print_r($this->pdo->errorInfo(),true));
            return $tarefa;
        }
    }
}