<?php
declare(strict_types=1);

use Valitron\Validator as Validator;


require_once 'usertoken.php';

function getAllUsers(object $qb): ?array
{
    
    $qb->select('*')->from('users');
    $results = $qb->executeQuery()->fetchAllAssociative();
    return $results;
}

function getUserToken(object $qb, string $username){

    $qb->select('token')->from('users')->where('username = ?')->setParameter(1,$username);
    $results = $qb->executeQuery()->fetchAssociative();
    return $results;

}

function getUserDetails(object $qb, string $username){

    $qb->select('*')->from('users')->where('username = ?')->setParameter(1,$username);
    $results = $qb->executeQuery()->fetchAssociative();
    return $results;

}

function IsUserValid(array $body): bool | array {
    $validator = new Validator($body);
    $validator->rule('required','username');
    if (!$validator->validate()){

        return $validator->errors();
    }
    else{
        return true;
    }

}

function addUser(object $qb, array $body) {

    $token = GenerateToken($body['username']);
    try {
        $qb->insert('users')
        ->setValue('username','?')
        ->setValue('token','?')
        ->setParameter(1,$body['username'])
        ->setParameter(2,$token);
            $results = $qb->executeStatement();
            return $results;
    } catch (Exception $th) {
        
       // Slim framework intercepts if exception is thrown, need to customise the error
    }
   

}





