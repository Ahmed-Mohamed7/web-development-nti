<?php

$filePath = 'data/data.txt';
## if file is not found or empty redirect to form page
if (!file_exists($filePath) || !filesize($filePath))
{
    echo "<SCRIPT> 
        alert('404 not found')
        window.location.replace('./task.php');
    </SCRIPT>";
}
if (isset($_POST['delete'])) {
    /*
    $f = fopen('data/data.txt', 'w') or die('enable to open file');
    fwrite($f, '');
    */
    unlink($filePath);
    
    header('location: ./profile.php');
}
else{
    $file = fopen($filePath, 'r') or die('unable to open file');
    while (!feof($file)) 
    {
        $line =  fgets($file);
        $data = json_decode($line);
    }
    fclose($file);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <img style="max-width: 100px; max-height:100px;" src=<?php echo $data->image ?>>
    <form action="./profile.php" method="POST">
   <?php
    foreach ($data as $key => $value) {
        echo "<br>".$key." : ".$value."<br>";
    }
    ?>
    <button type="submit" class="btn btn-primary" name="delete" >delete</button>
    </form>
</body>
</html>
