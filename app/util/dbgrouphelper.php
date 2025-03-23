<?php

declare(strict_types=1);

use Valitron\Validator as Validator;

function IsGroupNameValid(array $body): bool | array {
    $validator = new Validator($body);
    $validator->rule('required','group_name');
    return $validator->validate();

}
function IsGroupJoinDataValid(array $body):bool | array{
    $validator = new Validator($body);
    $validator->rule('required','group_id');
    $validator->rule('required','user_id');
    if (!$validator->validate()){
        return $validator->errors();
    }
    else {
        return true;
    }
}

function IsMessageDataValid(array $body):bool | array{
    $validator = new Validator($body);
    $validator->rule('required','group_id');
    $validator->rule('required','user_id');
    $validator->rule('required','message');
    if(!$validator->validate()){
        return $validator->errors();
    } else {
        return true;
    }
}

function IsGroupDataValid(array $body):bool | array{
    $validator = new Validator($body);
    $validator->rule('required','group_id');
    if(!$validator->validate()){
        return $validator->errors();
    } else {
        return true;
    }

}

function joinGroup(object $qb, array $body){

    
    try {
        $qb->insert('group_users')->setValue('group_id','?')->setValue('user_id','?')
        ->setParameter(1,$body["group_id"])->setParameter(2,$body["user_id"]);
        $results = $qb->executeStatement();
        return $results;
    } catch (Exception $th) {
        // Slim framework intercepts if exception is thrown, need to customise the error
    }
   

}

function addGroup(object $qb, array $body) {
    
    $qb->insert('groups')->setValue('name','?')->setParameter(1,$body['group_name']);
    try {
        $results = $qb->executeStatement();
        return $results;
    } catch (Exception $th) {
        //throw $th;
    }
    

}

function getGroupsAll(object $qb){
    $qb->select('*')->from('groups');
    $results = $qb->executeQuery()->fetchAllAssociative();
    return $results;

}

function postInGroup(object $qb, array $body){

    try {
        $qb->insert('messages')->setValue('group_id','?')->setValue('user_id','?')->setValue('message','?')
        ->setParameter(1,$body["group_id"])->setParameter(2,$body["user_id"])->setParameter(3,$body["message"]);
        $results = $qb->executeStatement();
        return $results;
       
    } catch (Exception $th) {
        //throw $th;
    }

}

function getGroupMessages(object $qb, array $body){
    try {
       
        $qb->select('m.id, m.user_id, u.username, m.message, m.timestamp')
        ->from('messages','m')->join('m','users','u','m.user_id = u.id')
        ->where('m.group_id = ?')->orderBy('m.timestamp', 'ASC')->setParameter(1,$body["group_id"]); 
        
        $results = $qb->executeQuery()->fetchAllAssociative();
        return $results;

    } catch (Exception $th) {
        //throw $th;
    }
}
