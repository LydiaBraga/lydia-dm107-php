<?php
class Entrega {
    private $id;
	private $numeroPedido;
	private $idCliente;
	private $nomeRecebedor;
	private $cpfRecebedor;
	private $dataEntrega;
    
    //construtor
    public function __construct(){
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getId(){
        return $this->id;
    }

    public function setNumeroPedido($numeroPedido){
        $this->numeroPedido = $numeroPedido;
    }

    public function getNumeroPedido(){
        return $this->numeroPedido;
    }
    
    public function setIdCliente($idCliente){
        $this->idCliente = $idCliente;
    }

    public function getIdCliente(){
        return $this->idCliente;
    }

    public function setNomeRecebedor($nomeRecebedor){
        $this->nomeRecebedor = $nomeRecebedor;
    }

    public function getNomeRecebedor(){
        return $this->nomeRecebedor;
    }

    public function setCpfRecebedor($cpfRecebedor){
        $this->cpfRecebedor = $cpfRecebedor;
    }

    public function getCpfRecebedor(){
        return $this->cpfRecebedor;
    }

    public function setDataEntrega($dataEntrega){
        $this->dataEntrega = $dataEntrega;
    }

    public function getDataEntrega(){
        return $this->dataEntrega;
    }

}
?>