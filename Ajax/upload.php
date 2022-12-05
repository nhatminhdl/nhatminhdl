<?php
include("db.php");
//Upload image
if($_FILES['file']['name']!=''){
    $extension = explode(".",$_FILES['file']['name']);
    $file_extension =end($extension);
    $allowed_type = array("jpg","jpeg","png","gif");
    if(in_array($file_extension,$allowed_type)){
        $new_name = rand(). "." . $file_extension;
        $path ="uploads/".$new_name;
        if(move_uploaded_file($_FILES['file']['tmp_name'],$path)){
            echo '
            <div class ="col-md-8">
            <img src ="'.$path.'" class ="img-reponsive">
            </div>
            <div class ="col-md-2">
                <button type="button" data-path="'.$path.'" id ="remove_button" class ="btn btn-danger">X</button>
            </div>
            ';
        }else{
            echo '<script>alert("File ảnh không thể upload  ")</script>';
        }
    }else{
        echo '<script>alert("Vui lòng chọn ảnh")</script>';
    }
   
}
if(!empty($_POST['path'])){
    if(unlink($_POST["path"])){
      echo  '';
    }
}
?>