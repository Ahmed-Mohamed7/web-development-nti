<?php

declare(strict_types=1);

function GetNextChar(string $char):string
{
    $a = ord('a');
    $A = ord('A');
    
    if($char>='a' && $char<='z')
    {
        #lower case
        return chr(( (ord($char) - $a) + 1) % 26 + $a); 
    }
    else if ($char>='A' && $char<='Z')
    {
        #upper case
        return chr(( (ord($char) - $A) + 1) % 26 + $A); 
    }
    return '-1';
}

$character =readline('Enter character: ');
$result = GetNextChar($character);
if($result == '-1')
    echo "you should enter a letter a-z A-Z\n";
else 
    echo $result;


?>
