<?php

    function traduzir_prioridade($prioridade) {
        switch($prioridade) {
            case 1: 
                return "Baixa";
            case 2: 
                return "Média";
            case 3: 
                return "Alta";
            default : return "";
        }
    }

    function traduzir_concluida($concluida){
        if ($concluida == 1)
            return "Sim";
        return "Não";
    }

    function traduz_data_para_banco($data) {

        if ($data == ''){
            return "";
        }

        $dados = explode("/", $data);

        if (count($dados) != 3){
            return $data;
        }

        $formatter = DateTime::createFromFormat('d/m/Y', $data);

        return $formatter->format('Y-m-d');

    }

    function traduz_data_para_exibir($data){
        if ($data == "" or $data == "0000-00-00"){
            return "";
        }

        $dados = explode("-", $data);

        if (count($dados) != 3){
            return $data;
        }

        $formatter = DateTime::createFromFormat('Y-m-d', $data);

        return $formatter->format('d/m/Y');
    }

    function validar_data($data){
        
        $pattern = '/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$/';
        $resp = preg_match($pattern, $data);

        if ($resp == 0){
            return false;
        }

        $dados = explode('/', $data);

        return checkdate($dados[0],$dados[1],$dados[2]);
    }

    function tem_post(){
        if (count($_POST) > 0){
            return true;
        }

        return false;
    }

    function tratar_anexo($anexo) {
        $padrao = '/^.+(\.pdf|\.zip)$/';
        $resultado = preg_match($padrao, $anexo["name"]);

        if ($resultado == 0) {
            return false;
        }

        move_uploaded_file($anexo["tmp_name"], "anexos/{$anexo["name"]}");
        return true;

    }

    function enviar_email($tarefa, $anexos = []){
        
        require "bibliotecas/PHPMailer/PHPMailerAutoload.php";

        $mail = new PHPMailer(); 
        $mail->isSMTP();
        $mail->Host = "mail.cck.com.br";
        $mail->Port = 465;
        $mail->SMTPSecure = "ssl";
        $mail->SMTPAuth = true;
        
        $mail->Username = "danilo@cck.com.br";
        $mail->Password = "";

        $mail->setFrom("danilo@cck.com.br","Avisador de Tarefas");

        $mail->addAddress(EMAIL_NOTIFICACAO);
        $mail->Subject = "Aviso de tarefa: {$tarefa['nome']}";

        $corpo = preparar_corpo_email($tarefa, $anexos);
        $mail->msgHTML($corpo);

        foreach ($anexos as $anexo) {
            $mail->addAttachment("anexos/{$anexo['arquivo']}");
        }

        if (!$mail->send()){
            error_log("Error " . $mail->ErrorInfo);
        }
    }

    function preparar_corpo_email($tarefa, $anexos){
        
        ob_start();
        include "template.php";
        $corpo = ob_get_contents();
        ob_end_clean();

        return $corpo;
    }