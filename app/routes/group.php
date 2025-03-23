<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


require_once APP_ROOT . '/util/dbgrouphelper.php';



$app->get('/api/groups/all', function (Request $request, Response $response) {
    $queryBuilder = $this->get('Db')->getQueryBuilder();
    $results = getGroupsAll($queryBuilder);
    $response->getBody()->write(json_encode($results));
    return $response;
});

$app->post('/api/groups/add',function(Request $request, Response $response){

    $queryBuilder = $this->get('Db')->getQueryBuilder();
   
    $body = $request->getParsedBody();
    $validation = IsGroupNameValid($body);
    
     
    if (is_array($validation))
    {
        $response->getBody()->write(json_encode($validation));
        return $response->withStatus(422);

    }else{
       
        $results = addGroup($queryBuilder,$body);
        if ($results){
            $response->getBody()->write(json_encode('Group created.'));
            return $response->withStatus(201);
        }else{
            $response->getBody()->write(json_encode(["error" => "Group name already exists."]));
            return $response->withStatus(400);
        }
    }
 });

 $app->post('/api/groups/join',function(Request $request, Response $response){
    $body = $request->getParsedBody();
    $queryBuilder = $this->get('Db')->getQueryBuilder();
    $validation = IsGroupJoinDataValid($body);
    
    if(is_array($validation)){

        $response->getBody()->write(json_encode($validation));
        return $response->withStatus(422);

    }
    else
    {
        $results = joinGroup($queryBuilder,$body);
        if ($results){
            $response->getBody()->write(json_encode('Group joined.'));
            return $response->withStatus(201);

        }else{

            $response->getBody()->write(json_encode(["error" => "User already part of the group."]));
            return $response->withStatus(400);
        }
    }

 });

 $app->post('/api/groups/messages/add',function(Request $request, Response $response){
    $body = $request->getParsedBody();
    $queryBuilder = $this->get('Db')->getQueryBuilder();
    $validation = IsMessageDataValid($body);

    if(is_array($validation)){
        $response->getBody()->write(json_encode($validation));
        return $response->withStatus(422);

    }
    else
    {
        $results = postInGroup($queryBuilder,$body);
        if ($results){
            
            $response->getBody()->write(json_encode('Message sent!.'));
            return $response->withStatus(201);

        }else{

            $response->getBody()->write(json_encode(["error" => "Failed to send message."]));
            return $response->withStatus(400);
        }
    }

 });

 $app->get('/api/groups/messages/get',function (Request $request, Response $response){
    $body = $request->getParsedBody();
    $queryBuilder = $this->get('Db')->getQueryBuilder();
    $validation = IsGroupDataValid($body);

    if(is_array($validation)){
        $response->getBody()->write(json_encode($validation));
        return $response->withStatus(422);

    }
    else
    {
        $results = getGroupMessages($queryBuilder,$body);
        
        if ($results){
            
            $response->getBody()->write(json_encode($results));
            return $response;

        }else{

            $response->getBody()->write(json_encode(["error" => "Failed to get messages."]));
            return $response->withStatus(400);
        }
    }


 });