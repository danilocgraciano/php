<?php

class RepositorioTarefas
{
    private $conexao;
    private $repositorio_anexos;

    public function __construct($conexao, $repositorio_anexos)
    {
        $this->conexao = $conexao;
        $this->repositorio_anexos = $repositorio_anexos;
    }

    public function salvar(Tarefa $tarefa)
    {
        $nome = $tarefa->getNome();
        $descricao = $tarefa->getDescricao();
        $prioridade = $tarefa->getPrioridade();
        $prazo = $tarefa->getPrazo();
        $concluida = ($tarefa->getConcluida()) ? 1 : 0;

        if (is_object($prazo)) {
            $prazo = $prazo->format('Y-m-d');
        }

        $query = "
            INSERT INTO tarefas 
            (nome, descricao, prioridade, prazo, concluida)
            VALUES
            (
                '{$nome}',
                '{$descricao}',
                {$prioridade},
                '{$prazo}',
                {$concluida}
            )
        ";

        $res = $this->conexao->query($query);

        if (!$res){
            error_log("Error " . mysqli_error($this->conexao));
        }
    }

    public function atualizar(Tarefa $tarefa)
    {
        $id = $tarefa->getId();
        $nome = $tarefa->getNome();
        $descricao = $tarefa->getDescricao();
        $prioridade = $tarefa->getPrioridade();
        $prazo = $tarefa->getPrazo();
        $concluida = ($tarefa->getConcluida()) ? 1 : 0;

        if (is_object($prazo)) {
            $prazo = $prazo->format('Y-m-d');
        }

        $query = "
            UPDATE tarefas SET
                nome = '{$nome}',
                descricao = '{$descricao}',
                prioridade = {$prioridade},
                prazo = '{$prazo}',
                concluida = '{$concluida}'
            WHERE id = {$id}
        ";

        $res = $this->conexao->query($query);

        if (!$res){
            error_log("Error " . mysqli_error($this->conexao));
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
        $resultado = $this->conexao->query($query);

        $tarefas = [];

        if (!$resultado){
            error_log("Error " . mysqli_error($this->conexao));
            return $tarefas;
        }


        while($tarefa = $resultado->fetch_object('Tarefa')) {
            $anexos = $this->repositorio_anexos->buscar_anexos($tarefa->getId()) ?? [];
            $tarefa->setAnexos($anexos);
            $tarefas[] = $tarefa;
        }

        return $tarefas;
    }

    private function buscar_tarefa($tarefa_id)
    {
        $query = "SELECT * FROM tarefas where id = {$tarefa_id}";
        $resultado = $this->conexao->query($query);

        $tarefa;

        if (!$resultado){
            error_log("Error " . mysqli_error($this->conexao));
            return $tarefa;
        }

        $tarefa = $resultado->fetch_object('Tarefa');
        $anexos = $this->repositorio_anexos->buscar_anexos($tarefa->getId()) ?? [];
        $tarefa->setAnexos($anexos);

        return $tarefa;
    }

    function remover($tarefa_id)
    {
        $query = "DELETE FROM tarefas where id = {$tarefa_id}";
        $res = $this->conexao->query($query);

        if (!$res){
            error_log("Error " . mysqli_error($this->conexao));
        }
    }
}