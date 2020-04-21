<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

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

    function traduz_data_br_para_objeto($data) {

        if ($data == ''){
            return "";
        }

        $dados = explode("/", $data);

        if (count($dados) != 3){
            return $data;
        }

        return DateTime::createFromFormat('d/m/Y', $data);

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
        $padrao = '/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$/';
        $resultado = preg_match($padrao, $data);

        if ($resultado == 0) {
            return false;
        }

        $dados = explode('/', $data);
        $dia = $dados[0];
        $mes = $dados[1];
        $ano = $dados[2];
        $resultado = checkdate($mes, $dia, $ano);
        
        return $resultado;
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

        move_uploaded_file($anexo["tmp_name"], __DIR__ . "/../anexos/{$anexo["name"]}");
        return true;

    }

    function enviar_email(Tarefa $tarefa){
        
        $mail = new PHPMailer(); 
        $mail->isSMTP();
        $mail->Host = getenv("MAIL_HOST");
        $mail->Port = getenv("MAIL_PORT");
        $mail->SMTPSecure = "ssl";
        $mail->SMTPAuth = true;
        
        $mail->Username = getenv("MAIL_USERNAME");
        $mail->Password = getenv("MAIL_PASSWORD");

        $mail->setFrom(getenv("MAIL_USERNAME"),"Avisador de Tarefas");

        $mail->addAddress(EMAIL_NOTIFICACAO);
        $mail->Subject = "Aviso de tarefa: {$tarefa->getNome()}";

        $corpo = preparar_corpo_email($tarefa);
        $mail->msgHTML($corpo);

        foreach ($tarefa->getAnexos() as $anexo) {
            $mail->addAttachment(__DIR__ . "/../anexos/{$anexo->getArquivo()}");
        }

        if (!$mail->send()){
            error_log("Error " . $mail->ErrorInfo);
        }
    }

    function preparar_corpo_email($tarefa){
        
        ob_start();
        include __DIR__ . "/../views/template.php";
        $corpo = ob_get_contents();
        ob_end_clean();

        return $corpo;
    }