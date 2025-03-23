<?php

function GenerateToken ($username): string {

    $options = [
        'cost' => 10
    ];
    return password_hash($username,PASSWORD_BCRYPT,$options);
}