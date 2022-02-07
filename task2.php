<?php

declare(strict_types=1);

function GetNextChar(string $char): string
{
    $a = ord('a');
    $A = ord('A');

    if ($char >= 'a' && $char <= 'z') 
    {
        #lower case
        $new_char = ord($char) - $a + 1;
        return chr($new_char % 26 + $a);
    } 
    else if ($char >= 'A' && $char <= 'Z') 
    {
        #upper case
        $new_char = ord($char) - $A + 1;
        return chr($new_char % 26 + $A);
    }
    return '-1';
}

$character = readline('Enter character: ');
$result = GetNextChar($character);
if ($result == '-1')
    echo "you should enter a letter a-z A-Z\n";
else
    echo $result;
