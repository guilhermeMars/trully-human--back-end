<?php

class User {

    private $id;
    private $nome;
    private $email;
    private $telefone;
    private $tipo_usuario;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    public function getTipoUsuario() {
        return $this->tipo_usuario;
    }

    public function setTipoUsuario($tipo_usuario) {
        $this->tipo_usuario = $tipo_usuario;
    }

    private function connection(){
        return new \PDO("mysql:host=localhost;port=3307;dbname=truly-human", "root", "");
    }

    public function create() :array{
        $con = this->connection();
        $stmt = $con->prepare("INSERT INTO users VALUES (NULL, :_nome, :_email, :_telefone, :_tipo)");
        $stmt->bindValue(":_name", $this->getNome(), \PDO::PARAM_STR);
        $stmt->bindValue(":_email", $this->getEmail(), \PDO::PARAM_STR);
        $stmt->bindValue(":_telefone", $this->getTelefone(), \PDO::PARAM_STR);
        $stmt->bindValue(":_tipo", $this->getTipoUsuario(), \PDO::PARAM_STR);
        if($stmt->execute()){
            $this->setId($con->lastInsertId());
            return this->read();
        }
        return [];
    }

    public function read() :array{
        $con = this->connection();
        if($this->getId() === 0){
            $stmt = $con->prepare("SELECT * FROM users");
            if($stmt->execute()){
                return $stmt->fetchAll(\PDO::FETCH_ASSOC); // Poderia colocar FETCH_OBJ para retornar objeto
            }
        } else if ($this->getId() > 0){
            $stmt = $con->prepare("SELECT * FROM users WHERE id = :_id");
            $stmt->bindValue(":_id", $this->getId(), \PDO::PARAM_INT);
            if($stmt->execute()){
                return $stmt->fetchAll(\PDO::FETCH_ASSOC); // Poderia colocar FETCH_OBJ para retornar objeto
            }
        }
        return [];
    }

    public function update() :array{
        $con = this->connection();
        $stmt = $con->prepare("UPDATE users SET nome = :_name, email = :_email, telefone = :_telefone, tipo = :_tipo WHERE id = :_id");
        $stmt->bindValue(":_id", $this->getId(), \PDO::PARAM_INT);
        $stmt->bindValue(":_name", $this->getNome(), \PDO::PARAM_STR);
        $stmt->bindValue(":_email", $this->getEmail(), \PDO::PARAM_STR);
        $stmt->bindValue(":_telefone", $this->getTelefone(), \PDO::PARAM_STR);
        $stmt->bindValue(":_tipo", $this->getTipoUsuario(), \PDO::PARAM_STR);
        if($stmt->execute()){
            return this->read();
        }
        return [];
    }

    public function delete() :array{
        $usuario = $this->read();
        $con = this->connection();
        $stmt = $con->prepare("DELETE FROM users WHERE id = :_id");
        $stmt->bindValue(":_id", $this->getId(), \PDO::PARAM_INT);
        if($stmt->execute()){
            return $usuario;
        }
        return [];
    }

}

?>