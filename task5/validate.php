<?php
session_start();
define('REQ_ERR', '<span style="color:red;">* Field Required</span>');
define('MIN_Size_Title', 5);
define('MIN_Size_Content', 50);
define('MAX_Size_Content', 100);
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
    $title =  Clean($_POST['title'], 0);
    $content = Clean($_POST['content'], 0);

    $errors = [];



    # validate name    
    if (empty($title))
        $errors['title'] = REQ_ERR;
    else if (!ctype_alpha($title))
        $errors['title'] = errorFormat('Title must be string');

    # validate email 
    if (empty($content))
        $errors['content'] = REQ_ERR;
    elseif (strlen($content) < MIN_Size_Content)
        $errors['content']   = errorFormat('content length must be >= ' . MIN_Size_Content . ' chars');

    #validate image
    $imgName = $_FILES['image']['name'];
    if (!empty($imgName)) {
        
        $imgTemp  = $_FILES['image']['tmp_name'];
        $imgType  = $_FILES['image']['type'];
        $imgSize  = $_FILES['image']['size'];

        $allowedExtensions = ['png', 'jpg', 'jfif', 'jpeg'];
        $tempName = explode('.', $imgName);
        $imgExtension =  strtolower(end($tempName));

        if ($imgSize > MAX_UPLOAD_SIZE)
            $errors['image'] = 'max upload size 5MB';
        else if (!in_array($imgExtension, $allowedExtensions))
            $errors['image'] = 'Invalid image extension';
        else {
            $imgName = time() . rand() . $imgName;
            $disPath = 'uploads/' . $imgName;
            if (!move_uploaded_file($imgTemp, $disPath))
                $errors['image'] = 'Invalid image extension';
            else
                $_SESSION['image'] = $disPath;
        }
    } 
    else {
        $errors['image'] = REQ_ERR;
    }



    #check for errors
    if (count($errors) == 0) {
       
        echo '<script> alert("data inserted successfully")</script>';
        $blog_data =  ['title' => $title, 'content' => $content,'image' =>$disPath];

        $file = fopen('data/data.txt', 'w') or die('enable to open file');
        fwrite($file, json_encode($blog_data));
        fclose($file);

        header("Location: ./profile.php");
    } else
        foreach ($errors as $key => $value) {
            echo $key . "  =>  " . $value . "<br>";
        }
}
