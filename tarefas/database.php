<?php

    $conn = mysqli_connect(BD_SERVIDOR, BD_USUARIO, BD_SENHA, BD_BANCO);

    if (mysqli_connect_errno($conn)) {
        error_log("Error " . mysqli_connect_error());
        die();
    }