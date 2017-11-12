<?php
class UsuarioDao {
    private $db;
    public function __construct() {
        $this->db = Banco::getConnection();
    }

    public function userExists($usuario, $senha) {
        $userCount = $this->db->usuario()->where("usuario = ?", $usuario)->where("senha = ?", $senha)->count("*");

        if ($userCount == 0) {
            return false;
        }

        return true;
    }

     public function getUsers() {
        $users = array();

        foreach ($this->db->usuario() as $user) {
            $users[$user["usuario"]] = $user["senha"];
        }

        return $users;
    }
}
?>