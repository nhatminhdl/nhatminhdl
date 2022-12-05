<?php
include("db.php");
?>
<?php
    if(isset($_POST['image_id'])){
        $old_name = get_old_image_name($_POST['image_id']);
        $file_array = explode('.',$old_name);
        $file_extension = end($file_array);
        $new_name = $_POST['image_name'].'.'.$file_extension;
        if($old_name != $new_name){
            $old_path = '../uploads/'.$old_name;
            $new_path = '../uploads/'.$new_name;
            if(rename($old_path,$new_path)){
                $query =mysqli_query($conn,"UPDATE tbl_image SET image_name ='".$new_name."', image_description ='".$_POST['image_description']."' WHERE image_id ='".$_POST['image_id']."'") ;
            }

        }else{
            $query = mysqli_query($conn,"UPDATE tbl_image SET image_description ='".$_POST['image_description']."' WHERE image_id ='".$_POST['image_id']."'");
        }
    }

    function get_old_image_name($image_id){
        global $conn;
            $query = mysqli_query($conn,"SELECT * FROM tbl_image WHERE image_id='".$image_id."'");
            while($row = mysqli_fetch_array( $query)){
                return $row['image_name'];

            }
    }
?>