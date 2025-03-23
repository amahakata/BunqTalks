<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


require_once APP_ROOT . '/util/dbuserhelper.php';

$app->get('/api/', function (Request $request, Response $response, $args) {
    $response_array= [
        'message' => 'Welcome to BunqTalks API : Users'
    ];
    $response_str = json_encode($response_array);
    $response->getBody()->write($response_str );
    return $response;
});
//Get All Users

$app->get('/api/users/',function (Request $request, Response $response){
    
    $queryBuilder = $this->get('Db')->getQueryBuilder();
    $results = getAllUsers($queryBuilder);
    $response->getBody()->write(json_encode($results));
    return $response;

});

//Get Token

$app->get('/api/users/getUserToken/{username}',function(Request $request, Response $response, array $args){

    $queryBuilder = $this->get('Db')->getQueryBuilder();
    $results = getUserToken($queryBuilder,$args['username']);
    $response->getBody()->write(json_encode($results));
    return $response;

});

// Get User Details

$app->get('/api/users/getUserDetails/{username}',function(Request $request, Response $response, array $args){

    $queryBuilder = $this->get('Db')->getQueryBuilder();
    
    $results = getUserDetails($queryBuilder,$args['username']);
    $response->getBody()->write(json_encode($results));
    return $response;

});

//Insert a User
$app->post('/api/users/add',function(Request $request, Response $response){

    $queryBuilder = $this->get('Db')->getQueryBuilder();
   
    $body = $request->getParsedBody();
    $results = IsUserValid($body);
    
     
    if (is_array($results))
    {
        $response->getBody()->write(json_encode($results));
        return $response->withStatus(422);

    }else{
        
        
        $results = addUser($queryBuilder,$body);
        if ($results){

            $response->getBody()->write(json_encode(["message" => "User registered successfully."]));
            return $response->withStatus(201);
        }
        else{
            $response->getBody()->write(json_encode(["error" => "Username taken"]));
            return $response->withStatus(400);

        }
    }

   

});

