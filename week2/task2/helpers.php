<?php 
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


?>