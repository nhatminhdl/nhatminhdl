<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload nhiều ảnh</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container" align="center">
        <h3>Upload nhiều hình ảnh</h3>
        <br>
        <input type="file" name="multiple_files" id="multiple_files" multiple />
        <span class="text-muted">Chỉ cho upload: jpg, jpeg, png, gif</span>
        <br>
        <span id="error_multiple_files"></span>
        <br>
        <div class="table-reponsive" id="image_table">

        </div>

    </div>

    <div id="edit_Modal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <form  method="POST"  id="edit_image_form">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Cập nhật hình ảnh</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Tên hình</label>
                            <input type="text" name="image_name" id="image_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Mô tả</label>
                            <input type="text" name="image_description" id="image_description" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="image_id" id="image_id" value="">
                        <input type="submit" class="btn btn-info" value="Cập nhật" >
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </form>


        </div>
    </div>



</body>
<script type="text/javascript">
    $(document).ready(function() {
        load_image_data();

        function load_image_data() {
            $.ajax({
                url: "fetch.php",
                method: "POST",
                success: function(data) {
                    $('#image_table').html(data);
                }
            });
        }
        $('#multiple_files').change(function() {
            var error_images = '';
            var form_data = new FormData();
            var files = $('#multiple_files')[0].files;
            if (files.length > 10) {
                // error_images += "Bạn không được upload quá 10 hình ảnh";
                $('#error_multiple_files').html(error_images += 'Bạn không được upload quá 10 hình ảnh');
                // alert( error_images+='Bạn không được upload quá 10 hình ảnh')
            } else {
                for (i = 0; i < files.length; i++) {
                    var name = document.getElementById('multiple_files').files[i].name;
                    var ext = name.split('.').pop().toLowerCase();

                    if (jQuery.inArray(ext, ['jpg', 'jpeg', 'png', 'gif']) == -1) {
                        error_images += '<p>Tập tin' + i + ' không hiệu lực</p>';
                        // alert( error_images += '<p>Tập tin'+ i +' không hiệu lực</p>');
                    }

                    var oFReader = new FileReader();
                    oFReader.readAsDataURL(document.getElementById('multiple_files').files[i]);
                    var f = document.getElementById('multiple_files').files[i];
                    var fsize = f.size || f.fileSize;
                    if (fsize > 2000000) {
                        error_images += '<p> Tệp' + i + ' quá kích thước cho phép </p>';
                    } else {
                        form_data.append("file[]", document.getElementById('multiple_files').files[i])
                    }
                }

            }
            if (error_images == '') {
                $.ajax({
                    url: "../upload_multi_images/upload.php",
                    method: "POST",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $('#error_multiple_files').html('<br/><label class ="text-primary">Đang tải...</label>');
                    },
                    success: function(data) {
                        $('#error_multiple_files').html('<br/><label class ="text-success">Đã tải thành công...</label>');
                        load_image_data();
                    }
                });
            }
        });
        $(document).on('click', '.delete', function() {
            var image_id = $(this).attr("id");
            var image_name = $(this).data("image_name");
            if (confirm('Bạn có chắc muốn xóa hình ảnh này không?')) {
                $.ajax({
                    url: "delete.php",
                    method: "POST",
                    data: {
                        image_id: image_id,
                        image_name: image_name
                    },
                    success: function(data) {
                        load_image_data();
                        alert('Xóa thành công');
                    }
                });
            }
        });
        $(document).on('click', '.edit', function() {
            var image_id = $(this).attr("id");
            $.ajax({
                    url: "edit.php",
                    method: "POST",
                    data:{
                        image_id: image_id
                    },
                    dataType:'json',
                    success: function(data) {
                        $('#edit_Modal').modal('show');
                        $('#image_id').val(image_id);
                        $('#image_name').val(data.name_image);
                        $('#image_description').val(data.description_image);
                    }
                });
            
            // alert(image_id);

        });

        $('#edit_image_form').on('submit',function(event){
            event.preventDefault();
            if($('#image_name').val() == ''){
                alert('Vui lòng nhập tên ảnh');
            }else{
                $.ajax({
                    url: "update.php",
                    method: "POST",
                    data:$('#edit_image_form').serialize(),
                    success: function(data) {
                        $('#edit_Modal').modal('hide');
                        load_image_data();
                        alert('Đã sửa thành công');
                    }
                });
            }
        });
    });
</script>

</html>