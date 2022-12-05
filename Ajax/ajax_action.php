<?php
include("db.php");
//Upload image
// if($_FILES['file']['name']!=''){
//     $extension = explode(".",$_FILES['file']['name']);
//     $file_extension =end($extension);
//     $allowed_type = array("jpg","jpeg","png","gif");
//     if(in_array($file_extension,$allowed_type)){
//         $new_name = rand(). "." . $file_extension;
//         $path ="uploads/".$new_name;
//         if(move_uploaded_file($_FILES['file']['tmp_name'],$path)){
//             echo '
//             <div class ="col-md-8">
//             <img src ="'.$path.'" class ="img-reponsive">
//             </div>
//             <div class ="col-md-2">
//                 <button type="button" data-path="'.$path.'" id ="remove_button" class ="btn btn-danger">X</button>
//             </div>
//             ';
//         }else{
//             echo '<script>alert("File ảnh không thể upload  ")</script>';
//         }
//     }else{
//         echo '<script>alert("Vui lòng chọn ảnh")</script>';
//     }

// }
// if(!empty($_POST['path'])){
//     if(unlink($_POST["path"])){
//       echo  '';
//     }
// }
//Select dữ liệu
if(isset($_POST['id_quocgia'])){
    $id_quocgia = $_POST['id_quocgia'];
    $sql_thudo = mysqli_query($conn, "SELECT * FROM tbl_thudo where id_quocgia='$id_quocgia' ");
    $output = '';
    $output = '<option>Chọn thủ đô</option>';
    if(mysqli_num_rows($sql_thudo)>0){
        while($row_thudo = mysqli_fetch_array($sql_thudo)){
            $output = '<option value ="'.$row_thudo['id_thudo'].'">'.$row_thudo['ten_thudo'].'</option>';
        }
    }
    echo $output;
}
//chèn dữ liệu
if (isset($_POST['hovaten'])) {
    $hovaten = $_POST['hovaten'];
    $sodienthoai = $_POST['sodienthoai'];
    $diachi = $_POST['diachi'];
    $email = $_POST['email'];
    $ghichu = $_POST['ghichu'];

    
    // $result = mysqli_query($conn,"INSERT INTO tbl_khachhang (hovaten,phone, email,address,ghichu) Value('$hovaten','$sodienthoai','$diachi',' $email',' $ghichu')");
    // $result = qury();
  
}
function qury(){
    global $hovaten;
    global $sodienthoai;
    global $diachi;
    global $email;
    global $ghichu;

    global $conn;
    return  mysqli_query($conn,"INSERT INTO tbl_khachhang (hovaten,phone, email,address,ghichu) Value('$hovaten','$sodienthoai','$diachi',' $email',' $ghichu')");
}
//Xóa dữ liệu
if (isset($_POST['id1'])) {
    $id = $_POST['id1'];
    
    
    $result = mysqli_query($conn,"DELETE FROM tbl_khachhang  Where khachhang_id = $id");
  
}
//edit dữ liệu
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $text = $_POST['text'];
    $column_name = $_POST['column_name'];
    
    $result = mysqli_query($conn,"UPDATE  tbl_khachhang SET $column_name='$text' Where khachhang_id = $id");
  
}
//lấy dữ liệu

$output ='';
$sql_select = mysqli_query($conn, "SELECT * FROM tbl_khachhang order by khachhang_id desc "); 
$output .= '
    <div class ="table table-reponsive">
        <table class="table table-bordered">
            <tr>
                <td>Họ và tên</td>
                <td>Số điện thoại</td>
                <td>Địa chỉ</td>
                <td>Email</td>
                <td>Ghi chú</td>
                <td>Quản lí</td>
            </tr>
   
';
if(mysqli_num_rows($sql_select) > 0){
    while($row = mysqli_fetch_array($sql_select)){
        $output .= '
            </tr>
                <td class ="hovaten" data-id1 ='.$row['khachhang_id'].' contenteditable>'.$row['hovaten'].'</td>
                <td contenteditable>'.$row['phone'].'</td>
                <td contenteditable>'.$row['email'].'</td>
                <td contenteditable>'.$row['address'].'</td>
                <td contenteditable>'.$row['ghichu'].'</td>
                <td><button data-id_del = '.$row['khachhang_id'].' class="btn btn-sm btn-danger del_data" name="delete_data">Xóa</button></td>
            </tr>
        ';

    }

}else{
    $output .='
        <tr>
            <td colspan="6" contenteditable>
            Dữ liệu chưa có
            </td>
        </tr>
    '; 
}
$output .='
</table>
</div>
';

echo $output;

?>