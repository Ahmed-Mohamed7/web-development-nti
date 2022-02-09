<?php
session_start();
define('REQ_ERR', '<span style="color:red;">* Field Required</span>');
#max  5 MB
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024);

function errorFormat($err)
{
    return '<span style="color:red;">*' . $err . '</span>';
}

function Clean($input, $flag = 1)
{
    $input =  trim($input);

    if ($flag == 0)
        $input =  filter_var($input, FILTER_SANITIZE_STRING);

    return $input;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name =  Clean($_POST['name'], 0);
    $email = Clean($_POST['email']);
    $password = Clean($_POST['password']);
    $address = Clean($_POST['address'], 0);
    $linkedinUrl = Clean($_POST['linkedinUrl']);
    $gender = Clean($_POST['gender']);

    $errors = [];



    # validate name    
    if (empty($name))
        $errors['name'] = REQ_ERR;
    else if (!ctype_alpha($name))
        $errors['name'] = errorFormat('Name Must be string');


    # validate email 
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
    if (empty($address))
        $errors['address'] = REQ_ERR;
    elseif (strlen($address) != 10)
        $errors['address'] = errorFormat('Address must be 10 characters');

    #validate gender
    if (empty($gender))
        $errors['gender'] = REQ_ERR;

    #validate url
    if (empty($linkedinUrl))
        $errors['linkedinUrl'] = REQ_ERR;
    elseif (!filter_var($linkedinUrl, FILTER_VALIDATE_URL))
        $errors['linkedinUrl'] = errorFormat('Invalid Url');

    #validate image
    if (!empty($_FILES['image']['name'])) 
    {
        $imgName  = $_FILES['image']['name'];
        $imgTemp  = $_FILES['image']['tmp_name'];
        $imgType  = $_FILES['image']['type'];
        $imgSize  = $_FILES['image']['size'];

        $allowedExtensions = ['png', 'jpg', 'jfif', 'jpeg'];
        $tempName = explode('.', $imgName);
        $imgExtension =  strtolower(end($tempName));
        
        if ($imgSize > MAX_UPLOAD_SIZE)
            $errors['image'] = 'max upload size 5MB';
        else if(!in_array($imgExtension,$allowedExtensions))
            $errors['image'] = 'Invalid image extension';
        else
        {
            $imgName = time() . rand() .$imgName;
            $disPath = 'uploads/' . $imgName;
            if(! move_uploaded_file($imgTemp,$disPath) )
                $errors['image'] = 'Invalid image extension';   
            else 
                $_SESSION['image'] = $disPath;            
        }
    }
    else
    {
        $errors['image'] = REQ_ERR;
    }

    #check for errors
    if (count($errors) == 0) {
        echo "<h1>data inserted successfully</h1>" . "<br>";
        foreach ($_POST as $key => $value) {
            $_SESSION[$key] = $value;
        }
        header("Location: ./profile.php");
    } else
        foreach ($errors as $key => $value) {
            echo $key . "  =>  " . $value . "<br>";
        }
}
