<?php
class EntregaDao {
    private $db;
    public function __construct() {
        $this->db = Banco::getConnection();
    }

    public function atualizarEntrega($entrega){
        $dbEntrega = $this->db->entrega()->where("id", $entrega["id"])->fetch();

        if ($dbEntrega != false) {
            $dbEntrega["nome_recebedor"] = $entrega["nome_recebedor"];
            $dbEntrega["cpf_recebedor"] =  $entrega["cpf_recebedor"];
            $dbEntrega["data_entrega"] = date("Y-m-d H:i:s", $entrega["data_entrega"]);

            return $dbEntrega->update();
        }
        
        return false;
    }

    public function removerEntrega($entregaId){        
        return $this->db->entrega()->where("id", $entregaId)->delete();
    }
}
?>