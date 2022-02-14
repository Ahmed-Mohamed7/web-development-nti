<?php
session_start();

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
    <div >
        <img style="max-width: 100px; max-height:100px;" src=<?php echo $_SESSION['image'] ?>>
    </div>
    <?php
        foreach ($_SESSION as $key => $value) {
            echo '<p>'.$key.' <span style="color:red";>'.$value.'</span></p>';
        }
     ?>
</body>
</html>