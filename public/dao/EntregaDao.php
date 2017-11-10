<?php
class EntregaDao {
    private $db;
    public function __construct() {
        $this->db = Banco::getConnection();
    }

    public function atualizarEntrega($entrega){
        $entregaToUpdate = $this->db->entrega()->where("id = ?", $entrega["id"]);

        if ($entregaToUpdate) {
            $entregaToUpdate["nomeRecebedor"] = $entrega["nomeRecebedor"];
            $entregaToUpdate["cpfRecebedor"] = $entrega["cpfRecebedor"];
            $entregaToUpdate["dataEntrega"] = $entrega["dataEntrega"];    

            $entregaToUpdate->update();
        }

        return $entregaToUpdate;
    }

    public function removerEntrega($entregaId){
        $deletedEntrega = $this->db->entrega()->where("id = ?", $entrega["id"])->delete();
        
        return $deletedEntrega;
    }

    public function getEntregas(){
        return $this->db->entrega();
    }
}
?>