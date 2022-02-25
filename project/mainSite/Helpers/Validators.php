<?php
require_once "helpers.php";

function Clean($input, $flag = 1)
{
    $input =  trim($input);

    if ($flag == 0)
        $input =  filter_var($input, FILTER_SANITIZE_STRING);

    return $input;
}

function errorFormat($err)
{
    return '<span style="color:red;">*' . $err . '</span>';
}

function CompareDate($date1, $date2)
{
    return strtotime($date2) >= strtotime($date1);
}

function Validate($input, $flag, $len = 10)
{
    $error = 0;
    switch ($flag) {
        case 'empty':
            if (empty($input))
                $error = 1;
            break;

        case 'string':
            if (!is_string($input)) // only letters and white spaces
                $error = 1;
            break;

        case 'email':
            if (!filter_var($input, FILTER_VALIDATE_EMAIL))
                $error = 1;
            break;

        case 'lengthG':
            if (strlen($input) >= $len)
                $error = 1;
            break;

        case 'lengthS':
            if (strlen($input) < $len)
                $error = 1;
            break;

        case 'number':
            if (!ctype_digit($input))
                $error = 1;
            break;

        case 'gender':
            if (!in_array($input, ['male', 'female']))
                $error = 1;
            break;

        case 'date':
            $testDate = explode('-', $input);
            if (!checkdate($testDate[1], $testDate[2], $testDate[0]))
                $error = 1;
            break;

        case 'bool':
            if (empty($input) && $input !== '0')
                $error = 1;
            else if (!filter_var($input, FILTER_VALIDATE_BOOL) && $input !== '0')
                $error = 1;
            break;

        case 'url':
            if (!filter_var($input, FILTER_VALIDATE_URL))
                $error = 1;
            break;

        case 'phone':
            $input = str_replace([' ', '.', '-', '(', ')'], '', $input);
            if (!ctype_digit($input))
                $error = 1;
            else if (strlen($input) < 7 || strlen($input) > 16)
                $error = 1;
            break;

        case 'maxUploadSize':
            if ($input > MAX_UPLOAD_SIZE)
                $error = 1;

        case 'extension':
            global $allowedExtensions;
            if (!in_array($input, $allowedExtensions))
                $error = 1;
            break;

        }
    return $error;
}
