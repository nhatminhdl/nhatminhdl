<?php
include("db.php");
?>
<?php
//lấy dữ liệu
$query = mysqli_query($conn,"SELECT * from tbl_image order by image_id desc");
$number_of_rows = mysqli_num_rows($query);
$output ='';
$output .= '<table class = "table table-bordered table-triped">
                <tr>
                    <th>Thứ thự</th>
                    <th>Hình ảnh</th>
                    <th>Tên</th>
                    <th>Mô tả</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>';
if($number_of_rows >0){
    $count = 0;
    while($row = mysqli_fetch_array($query)){
        $count ++;
        $output .= '
        <tr>
            <td>'.$count.'</td>
            <td><img src="../uploads/'.$row['image_name'].'" class ="img img-thumbnail" width ="100" height ="100"></td>
            <td >'.$row['image_name'].'</td>
            <td>'.$row['image_description'].'</td>
            <td><button type ="button" class="btn btn-warning btn-xs edit" id="'.$row['image_id'].'">Edit</button></td>
            <td><button type ="button" data-image_name="'.$row['image_name'].'"class="btn btn-danger btn-xs delete" id="'.$row['image_id'].'">Delete</button></td>
        </tr>';
    }
}else{
    $output .= '
        <tr>
            <td colspan="6" align ="center">Chưa có dữ liệu</td>
        </tr>';
}
$output .='</table>';
echo $output;
?>