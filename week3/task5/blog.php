<?php
require_once "./connection.php";
require_once "./validators.php";

$ERRS = [
    'empty' => '* Field is required', 'string' => '*Field Must be string', 'number' => '*Field Must be number',
    'imgEmpty' => '*image required',
    'imgExt' => 'invalid extension',
    'lenS' => 'invalid length'
];
$allowedExtensions = ['png', 'jpg', 'jfif', 'jpeg'];

class Blog
{

    private $title;
    private $content;
    private $image;
    private $imgName;
    private $result;

    public function Create($data)
    {
        global $ERRS;
        global $allowedExtensions;
        $this->title = Validator::Clean($data['title']);
        $this->content = Validator::Clean($data['content']);
        $this->image = $_FILES['image'];

        $errors = [];

        #validate title
        $titleErr = Validator::required($this->title, 'empty||string');
        if (!empty($titleErr))
            $errors['title'] =  $ERRS[$titleErr];

        #VALIDATE CONTENT
        $contentErr = Validator::required($this->content, 'empty||lenS:50');
        if (!empty($contentErr))
            $errors['content'] =  $ERRS[$contentErr];

        #validate image
        $imageErr = Validator::required($this->image, 'imgEmpty||imgExt');
        if (!empty($imageErr))
            $errors['image'] =  $ERRS[$imageErr];


        if (count($errors) == 0) {

            ## set image
            $this->imgName = Validator::GenerateName($this->image['name']);
            $disPath = 'uploads/' . $this->imgName;
            if (!move_uploaded_file($this->image['tmp_name'], $disPath)) {
                exit;
                $errors['image'] = 'error while upload image';
                $this->result = $errors;
            } else {
                $dbObj = new Connection();
                $sql = "INSERT INTO `blog`(`title`, `content`, `image`) VALUES ('$this->title','$this->content','$this->imgName')";
                $op = $dbObj->doQuery($sql);
                if ($op)
                    $this->result = ["Success" => "data Inserted"];
                else
                    $this->result = ["Error" => "Error Try Again"];
            }
        } else {
            $this->result = $errors;
        }
        return $this->result;
    }


    public function showData($flag = 0, $id = '')
    {

        # Create Db Obj .... 
        $dbObj = new Connection;
        if ($flag == 0)
            $sql = "select * from blog ";
        else
            $sql = "select * from blog where id = $id";

        $result = $dbObj->doQuerySelect($sql);

        return $result;
    }

    public function edit($id, $data,$old_image='')
    {
        global $ERRS;
        global $allowedExtensions;
        $this->result = [];
        $this->title = Validator::Clean($data['title']);
        $this->content = Validator::Clean($data['content']);
        $this->image = $_FILES['image'];

        $errors = [];

        #validate title
        $titleErr = Validator::required($this->title, 'empty||string');
        if (!empty($titleErr))
            $errors['title'] =  $ERRS[$titleErr];

        #VALIDATE CONTENT
        $contentErr = Validator::required($this->content, 'empty||lenS:50');
        if (!empty($contentErr))
            $errors['content'] =  $ERRS[$contentErr];

        #validate image
        $img_found = true;
        if (!empty($_FILES['image']['name'])) {
            $imageErr = Validator::required($this->image, 'imgExt');
            if (!empty($imageErr))
                $errors['image'] =  $ERRS[$contentErr];
        } else {
            $img_found = false;
        }


        if (count($errors) == 0) {
            $err = false;
            ## set image
            if ($img_found) {
                $this->imgName = Validator::GenerateName($this->image['name']);
                $disPath = 'uploads/' . $this->imgName;
                if (!move_uploaded_file($this->image['tmp_name'], $disPath)) {
                    $errors['image'] = 'error while upload image';
                    $this->result = $errors;
                    $err = true;
                }
                $img_q = ",`image`='$this->imgName'";
                if(!empty($old_image))
                    unlink('./uploads/' . $old_image);
            } else
                $img_q = '';

            if (!$err) {
                $dbObj = new Connection();
                $sql = "UPDATE `blog` SET `title`='$this->title',`content`='$this->content' $img_q  WHERE id = $id";
                $op = $dbObj->doQuery($sql);
                if ($op)
                    $this->result = ["Success" => "data updated successfully"];
                else
                    $this->result = ["Error" => "Error Try Again"];
            } else
                $this->result = $errors;
        }
        else    $this->result = $errors;
        return $this->result;
    }

    public function remove($id)
    {
        # Create Db Obj .... 
        $dbObj = new Connection;

        $sql = "delete from blog where id = $id";

        $this->result = $dbObj->doQuery($sql);

        return $this->result;
    }
}
$b = new Blog();
$b->Create(['title' => '', 'content' => 'wowoww']);
