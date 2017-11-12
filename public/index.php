<?php
    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;

    require 'dao/Banco.php';
    require 'dao/EntregaDao.php';
    require 'dao/UsuarioDao.php';
    require 'validator/EntregaValidator.php';

    require '../vendor/autoload.php';

    $app = new \Slim\App;

    $username = isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : NULL;
	$password = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : NULL;

    $usuarioDao = new UsuarioDao();
    
    if ($usuarioDao->userExists($username, $password)) {
		$app->add(new Tuupola\Middleware\HttpBasicAuthentication([
				"users" => [
					$username => $password
				]
		]));

        $app->post('/api/entrega', function(Request $request, Response $response) {
            $entregaDao = new EntregaDao();
            $entregaValidator = new EntregaValidator();
            $entrega = $request->getParsedBody();

            if (!$entregaValidator->isEntregaValidForUpdate($entrega)) {
                return $response->withStatus(400)->write("Os campos nome do recebedor, cpf do recebedor e data de entrega são obrigatórios!");
            } else {
                $updatedEntrega = $entregaDao->atualizarEntrega($entrega);

                if ($updatedEntrega != false) {
                    return $response->withStatus(200)->write("Entrega atualizada!");
                }

                return $response->withStatus(500)->write("Erro ao atualizar entrega!");
            }

        });

        $app->delete('/api/entrega/{id}', function(Request $request, Response $response) {
            $entregaDao = new EntregaDao();
            $entregaId = $request->getAttribute('id');

            $deletedEntrega = $entregaDao->removerEntrega($entregaId);

            if ($deletedEntrega != false) {
                return $response->withStatus(200)->write("Entrega removida!");
            }

            return $response->withStatus(500)->write("Erro ao remover entrega!");
        });
	} else {
        $app->add(new Tuupola\Middleware\HttpBasicAuthentication([
            "users" => $usuarioDao->getUsers(),
            "error" => function ($request, $response, $arguments) {
                $data = [];
                $data["status"] = "error";
                $data["message"] = $arguments["message"];

                return $response->write(json_encode($data, JSON_UNESCAPED_SLASHES), 401);
            }
		]));
    }
    
    $app->run();
?>