<?php
    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;

    require 'dao/Banco.php';
    require 'dao/EntregaDao.php';
    require 'dao/UsuarioDao.php';

    require '../vendor/autoload.php';

    $app = new \Slim\App;

    $username = $_SERVER['PHP_AUTH_USER'];
	$password = $_SERVER['PHP_AUTH_PW'];

    $usuarioDao = new UsuarioDao();
    
    if ($usuarioDao->userExists($username, $password)) {
		$app->add(new Tuupola\Middleware\HttpBasicAuthentication([
				"users" => [
					$username => $password
				]
		]));

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
	} else {
        $app->add(new Tuupola\Middleware\HttpBasicAuthentication([
            "users" => $usuarioDao->getUsers(),
            "error" => function ($request, $response, $arguments) {
                    $data = [];
                $data["status"] = "error";
                $data["message"] = $arguments["message"];
                return $response->write(json_encode($data, JSON_UNESCAPED_SLASHES));
            }
		]));
    }
    
    $app->run();
?>