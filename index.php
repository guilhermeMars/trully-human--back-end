<?php
    require_once "User.php";

    header("Content-Type: application/json");
    $data = [];

    $fn = $_REQUEST["fn"] ?? null;
    $id = $_REQUEST["id"] ?? 0;
    $nome = $_REQUEST["nome"] ?? null;
    $email = $_REQUEST["email"] ?? null;
    $telefone = $_REQUEST["telefone"] ?? null;
    $tipo_usuario = $_REQUEST["tipo_usuario"] ?? null;

    $user = new User;
    $user->setId($id);

    if($fn === "create" && $name !== null){
        $user->setNome($nome);
        $user->setEmail($email);
        $user->setTelefone($telefone);
        $user->setTipoUsuario($tipo_usuario);
        $data["user"] = $user->create();
    }

    if($fn === "read"){
        $data["user"] = $user->read();
    }

    if($fn === "update" && $name !== null && $id > 0){
        $user->setNome($nome);
        $user->setEmail($email);
        $user->setTelefone($telefone);
        $user->setTipoUsuario($tipo_usuario);
        $data["user"] = $user->update();
    }

    if($fn === "delete" && $id > 0){
        $data["user"] = $user->delete();
    }

    die(json_encode($data));
?>