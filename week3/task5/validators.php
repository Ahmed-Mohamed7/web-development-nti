<?php

$allowedExtensions = ['png', 'jpg', 'jfif', 'jpeg'];

class Validator
{
    ## no constructor so no need to make obj  so i think static is better 

    public static function  Clean($input, $flag = 0)
    {

        $input =  trim($input);

        if ($flag == 0) {
            $input =  filter_var($input, FILTER_SANITIZE_STRING);
        }
        return $input;
    }

    static public function  validate($input, $flag, $len = 10)
    {
        global $allowedExtensions;
        $status = true;

        switch ($flag) {
            case 'empty':
                # code...
                if (empty($input)) {
                    $status = false;
                }

                break;

            case 'email':
                # Code ... 
                if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
                    $status = false;
                }
                break;


            case 'lenS':
                # Code .... 
                if (strlen($input) < $len) {
                    $status = false;
                }
                break;

            case 'lenG':
                # Code .... 
                if (strlen($input) > $len) {
                    $status = false;
                }
                break;

            case 'number':
                # Code .... 
                if (!filter_var($input, FILTER_VALIDATE_INT)) {
                    $status = false;
                }
                break;

            case 'imgExt':
                # Code ....
                $input = $input['name']; 
                $nameArray =  explode('.', $input);
                $imgExtension =  strtolower(end($nameArray));


                if (!in_array($imgExtension, $allowedExtensions)) {
                    $status = false;
                }
                break;

            case 'imgEmpty':
                # Code .... 
                if(empty($input['name']))
                    $status =false;
                break;

            case 6:
                # code ... 
                $date = explode('-', $input);

                if (!checkdate($date[1], $date[2], $date[0])) {
                    $status = false;
                }

                break;


            case 7:
                # code .... 
                $date = strtotime($input);

                if ($date <= time()) {
                    $status = false;
                }
                break;



            case 'string':     // te stt     
                #code ..... 
                if (!preg_match('/^[a-zA-Z\s]*$/', $input)) {
                    $status = false;
                }
                break;


            case 9:     // te stt     
                #code ..... 
                if (!preg_match('/^01[0-2,5][0-9]{8}$/', $input)) {
                    $status = false;
                }
                break;
        }

        return $status;
    }

    static function required($input, $validators)
    {
        $valids = explode('||', $validators);

        for ($i = 0; $i < count($valids); $i++) {

            if (str_contains($valids[$i], 'len')) {
                $temp = explode(':', $valids[$i]);
                $len = end($temp);
                $valids[$i] = $temp[0];
                if (!self::validate($input, $valids[$i], $len)) {
                    return $valids[$i];
                    break;
                }
            } else {
                if (!self::validate($input, $valids[$i])) {
                    return $valids[$i];
                    break;
                }
            }
        }
    }

    static function GenerateName($imgName){
        return time() . rand() . $imgName;
    }
}
