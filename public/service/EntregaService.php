<?php
    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;

    include "dao/Banco.php";
    include "dao/EntregaDao.php";

    require '../vendor/autoload.php';

    $entregaDao = new EntregaDao();

    $app = new \Slim\App;

    $app -> post('/api/entrega', function(Request $request, Response $response) {
        $entrega = $request -> getBody();

        if ($entrega["nomeRecebedor"] === NULL || $entrega["cpfRecebedor"] === NULL || $entrega["dataEntrega"] === NULL) {
            return $response -> getBody()
                                ->write("Os campos nome do recebedor, cpf do recebedor e data de entrega são obrigatórios!")
                                ->withStatus(400);
        } else {
            $updatedEntrega = $entregaDao.atualizarEntrega($entrega);

            return $response -> withJson($updatedEntrega)
                                ->withStatus(200);
        }

    });

    $app -> delete('/api/entrega/{id}', function(Request $request, Response $response) {
        $entregaId = $request -> getAttribute('id');

        $deletedEntrega = $entregaDao.removerEntrega($entregaId);

        return $response -> withJson($deletedEntrega)
                            ->withStatus(200);
    });
    
    $app -> run();
?>