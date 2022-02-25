<?php 
define('REQ_ERR', '<span style="color:red;">* Field Required</span>');
#max  5 MB
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024);

function errorFormat($err)
{
    return '<span style="color:red;">*' . $err . '</span>';
}

#Name Validator

function ValidateName($name,$len = 50)
{
    $error = '';
    if(empty($name))
        $error =REQ_ERR; 
    else if(! is_string($name) ) // only letters and white spaces
        $error = errorFormat('name must be string');
    else if( strlen($name)>= $len)
        $error = 'name must be <= '.$len.'characters';

    return $error;
}

#Email Validator
function ValidateEmail($email)
{   
    $error = null;
    if(empty($email))
        $error = REQ_ERR; 
    else if (!filter_var($email,FILTER_VALIDATE_EMAIL))
        $error = ErrorFormat('invalid email');
    return $error;
}

#Password Validator
function ValidatePassword($pass,$len=8)
{
    $error = '';
    if(empty($pass))
        $error =REQ_ERR; 
    else if(strlen($pass) < $len)
        $error = errorFormat('password must be > '.$len.'characters');
    return $error;
}

#address validator
function ValidateAddress($address,$len=255)
{
    $error = '';
    if(empty($address))
        $error =REQ_ERR; 
    else if(! is_string($address) ) // only letters and white spaces
        $error = errorFormat('address must be string');
    else if( strlen($address)>= $len)
        $error = ErrorFormat('address must be <= '.$len.'characters');

    return $error;
}

#phone validator
function ValidatePhone($phone)
{
    $error = '';

    if(empty($phone))
        $error =REQ_ERR;
    else if(strlen($phone)<8 || strlen($phone) > 20)
        $error = ErrorFormat('invalid phone number');
    
        // Remove "-" from number
    return $error;
}

function ValidateNumbers($number , $from =0,$to=PHP_INT_MAX)
{
    $error = '';
    if(empty($number))
        $error =REQ_ERR;
    else if(!ctype_digit($number))
        $error = ErrorFormat('invalid number');
    else if ($number< $from || $number >$to)
        $error = ErrorFormat('invalid value');
    return $error;
}

function ValidateGender($gender)
{
    $error = '';
    if(empty($gender))
        $error =REQ_ERR;
    else if (!in_array($gender,['male','female']) )
        $error = errorFormat('gender must be either male or female');
    return $error;
}

function ValidateDate($date)
{
    $error = '';
    $testDate = explode('-',$date);
    echo $date;
    if(empty($date))
        $error =REQ_ERR;
    else if (!checkdate($testDate[1],$testDate[2],$testDate[0]))
        $error = errorFormat('invalid date');
    return $error;
}

function ValidateBoolean($value)
{
    $error = '';
    echo var_dump($value);
    if(empty($value) && $value !== '0')
        $error =REQ_ERR;
    else if (!filter_var($value,FILTER_VALIDATE_BOOL) && $value !== '0')
        $error = errorFormat('invalid type, expect bool');
    return $error;
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

?>