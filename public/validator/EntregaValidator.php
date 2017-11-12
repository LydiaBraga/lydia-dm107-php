<?php
class EntregaValidator {

    public function isEntregaValidForUpdate($entrega){
        if ($this->isFieldDefined($entrega, "id")
                && $this->isFieldDefined($entrega, "nome_recebedor")
                && $this->isFieldDefined($entrega, "cpf_recebedor")
                && $this->isFieldDefined($entrega, "data_entrega"))  {
            return true;
        }

        return false;
    }

    private function isFieldDefined($entrega, $field) {
        return (isset($entrega[$field]) && $entrega[$field] != NULL);
    }

}
?>