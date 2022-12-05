<?php
include("db.php");
?>
<?php
if($_POST['image_id']){
        $file_path ='../uploads/'.$_POST['image_name'];
        if(unlink($file_path)){
        $query = mysqli_query($conn,"DELETE from tbl_image where image_id ='".$_POST['image_id']."'");
    }
    

}
?>