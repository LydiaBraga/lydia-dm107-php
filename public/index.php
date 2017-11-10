<?php
    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;

    require 'dao/Banco.php';
    require 'dao/EntregaDao.php';

    require '../vendor/autoload.php';

    $app = new \Slim\App;

    $app->get('/api/entrega', function(Request $request, Response $response) {
        $entregaDao = new EntregaDao();
        $entregas = $entregaDao->getEntregas();

        return $response->withJson($entregas)->withStatus(200);
    });

    $app->post('/api/entrega', function(Request $request, Response $response) {
        $entregaDao = new EntregaDao();
        $entrega = $request->getBody();

        if ($entrega["nomeRecebedor"] === NULL || $entrega["cpfRecebedor"] === NULL || $entrega["dataEntrega"] === NULL) {
            return $response->getBody()->write("Os campos nome do recebedor, cpf do recebedor e data de entrega são obrigatórios!")->withStatus(400);
        } else {
            $updatedEntrega = $entregaDao->atualizarEntrega($entrega);

            return $response->withJson($updatedEntrega)->withStatus(200);
        }

    });

    $app->delete('/api/entrega/{id}', function(Request $request, Response $response) {
        $entregaDao = new EntregaDao();
        $entregaId = $request->getAttribute('id');

        $deletedEntrega = $entregaDao->removerEntrega($entregaId);

        return $response->withJson($deletedEntrega)->withStatus(200);
    });
    
    $app->run();
?>