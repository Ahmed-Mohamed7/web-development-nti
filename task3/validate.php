<?php

define('REQ_ERR','<span style="color:red;">* Field Required</span>');

function errorFormat($err)
{
    return '<span style="color:red;">*'.$err.'</span>';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name =  $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $linkedinUrl = $_POST['linkedinUrl'];
    
    $errors = [];
    
    # validate name
    $name  = trim($name);
    if (empty($name))
        $errors['name'] = REQ_ERR;
    else if (!ctype_alpha($name))
        $errors['name'] = errorFormat('Name Must be string');

    # validate email 
    $email  = trim($email);
    if (empty($email))
        $errors['email'] = REQ_ERR;
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))
        $errors['Email']   = errorFormat('Invalid Email');


    # validate password 
    if (empty($password))
        $errors['password'] = REQ_ERR;
    elseif (strlen($password) < 6)
        $errors['Password'] = errorFormat('Length Must be >= 6 chars');

    #validate address
    $address  = trim($address);
    if (empty($address))
        $errors['address'] = REQ_ERR;
    elseif (strlen($address) != 10)
        $errors['address'] = errorFormat('Address must be 10 characters');

    #validate url
    $linkedinUrl = trim($linkedinUrl);
    if (empty($linkedinUrl))
        $errors['linkedinUrl'] = REQ_ERR;
    elseif (!filter_var($linkedinUrl, FILTER_VALIDATE_URL))
        $errors['linkedinUrl'] = errorFormat('Invalid Url');

    #check for errors
    if (count($errors) == 0) 
    {
        echo "<h1>data inserted successfully</h1>"."<br>";
        foreach ($_POST as $key => $value) {
            echo $key.'   =>    '.$value.'<br>';
        }
    }
    else 
        foreach ($errors as $key => $value) {
            echo $key."  =>  ".$value."<br>";
        }
}
