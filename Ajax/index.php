<?php
include('db.php');
$sql_quocgia = mysqli_query($conn, "Select * from tbl_quocgia order by id_quocgia ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <title>Ajax</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <div class="col-md-12">
            <h3>Insert dữ liệu trong form</h3>
        <form action="" method="POST" id="insert_data_hoten">
            <label>Họ và tên</label>
            <input type="text" class="form-control" id="hovaten" placeholder="Điền họ và tên">
            <label>Số điện thoại</label>
            <input type="text" class="form-control" id="sophone"placeholder="Số điện thoại">
            <label>Địa chỉ</label>
            <input type="text" class="form-control" id="diachi" placeholder="Địa chỉ">
            <label>Email</label>
            <input type="text" class="form-control" id="email"placeholder="Email">
            <label>Ghi chú</label>
            <input type="text" class="form-control" id="ghichu" placeholder="Ghi chú">
            <input type="button" id="button_insert" name="insert_data" value="Insert" class="btn btn-success">
        </form>
        <div>

        </div>
            <h3>Load dữ liệu trong form</h3>
            <div id="load_data"></div>
            <h3>Select dữ liệu bằng Ajax</h3>
                <label for="">Quốc gia</label>
                <select class="form-control" id="quocgia" name = "quocgia">
                    <option value="" >Chọn quốc gia</option>
                    <?php
                    while ($row_quocgia = mysqli_fetch_array($sql_quocgia)) {
                        echo '<option value="'.$row_quocgia['id_quocgia'].'">'.$row_quocgia['ten_quocgia'].'</option>';
                    }
                    ?>
                </select>
                <label for="">Thủ đô</label><br>
                <select class="form-control" id="thudo" name="thudo">
                 
                </select>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
           $('#quocgia').change(function(){
                var id_quocgia = $(this).val();
                $.ajax({
               url: "ajax_action.php",
               method: "POST",
               data: {id_quocgia:id_quocgia},
               success:function(data){
                    $('#thudo').html(data);
               }
           });
                
           });

        });
    </script>
    <script type="text/javascript">

        $(document).ready(function(){
      
        //Load dữ liệu   
        function fetch_data(){
            $.ajax({
               url: "ajax_action.php",
               method: "POST",
               success:function(data){
                $('#load_data').html(data);
               }
              
           });
        }
        fetch_data();
        //Delete dữ liệu
        $(document).on('click','.del_data',function(){
            var id1 = $(this).data('id_del');
            $.ajax({
               url: "ajax_action.php",
               method: "POST",
               data: {id1:id1},
               success:function(data){
                       alert('Xóa dữ liệu thành công');
                       fetch_data();
               }
           });
          
        });
        //Edit dữ liệu
        function edit_data(id,text,column_name){
            $.ajax({
               url: "ajax_action.php",
               method: "POST",
               data: {id:id, text:text,column_name:column_name},
               success:function(data){
                       alert('Edit dữ liệu thành công');
                       fetch_data();
               }
           });
        }
           
        $(document).on('blur','.hovaten',function(){
            var id = $(this).data('id1');
            var text = $(this).text();
            edit_data(id,text,"hovaten");
        });
        
        
        
        //insert dữ liệu
        $('#button_insert').on('click',function(){
       
       var hovaten = $('#hovaten').val();
       var sodienthoai = $('#sophone').val();
       var diachi = $('#diachi').val();
       var email = $('#email').val();
       var ghichu = $('#ghichu').val();

       if (hovaten ==''|| sodienthoai ==''|| diachi ==''|| email =='' || ghichu =='') {
           alert('Không được bỏ trống các trường');
       }else{
           $.ajax({
               url: "ajax_action.php",
               method: "POST",
               data: {hovaten:hovaten, sodienthoai:sodienthoai,diachi:diachi,email:email,ghichu:ghichu},
               success:function(data){
                       alert('Insert dữ liệu thành công');
                       fetch_data();
                       $('#insert_data_hoten')[0].reset();
                       
               }
           });
       }
      
       
  });
            });
            
           
    </script>
</body>
</html>