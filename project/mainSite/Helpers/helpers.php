<?php
define('IMG_PATH',str_replace('/', '\\', $_SERVER['DOCUMENT_ROOT']."/nti_course/project/uploads/"));
define('IMG_SRC',"http://localhost/nti_course/project/uploads/");


define('REQ_ERR', '<span style="color:red;">* Field Required</span>');
#max  5 MB
define('MAX_UPLOAD_SIZE', 5 *1024* 1024 * 1024);
$allowedExtensions = ['png', 'jpg', 'jfif', 'jpeg'];


function SetImageName($name, $path)
{
    $imgName = time() . rand() . $name;
    return $path . $imgName;
}
function url($input)
{
    $link = "http://". $_SERVER['HTTP_HOST'] ."/nti_course/project/mainSite/sock/".$input;
    return $link;
}
?>
