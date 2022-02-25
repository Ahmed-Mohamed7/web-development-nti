<?php 

function Clean($input, $flag = 1)
{
    $input =  trim($input);

    if ($flag == 0)
        $input =  filter_var($input, FILTER_SANITIZE_STRING);

    return $input;
}

function CompareDate($date1,$date2)
{
    return strtotime($date2)>=strtotime($date1);
}

?>