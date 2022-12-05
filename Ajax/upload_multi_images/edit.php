<?php
include("db.php");
?>
<?php
    $query = mysqli_query($conn,"SELECT * FROM tbl_image WHERE image_id='".$_POST['image_id']."'");
    while ($row = mysqli_fetch_array($query)) {
        $file_array = explode('.',$row['image_name']);
        $output['name_image'] = $file_array[0];
        $output['description_image'] = $row['image_description'];
        
      

    }
    echo json_encode($output);

    // print_r($output) ;
?>