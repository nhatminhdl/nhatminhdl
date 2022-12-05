@extends('welcome')
@section('content')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="#">Trang chủ</a></li>
              <li class="active">Thanh toán giỏ hàng</li>
            </ol>
        </div>

        
        </div>
        <div class="review-payment">
            <h2>Xem lại giỏ hàng và thanh toán</h2>
        </div>

        <div class="table-responsive cart_info">
            <?php
        $content = Cart::content();
            ?>
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Hình ảnh</td>
                        <td class="description">Mô tả</td>
                        <td class="price">Giá</td>
                        <td class="quantity">Số lượng</td>
                        <td class="total">Tổng tiền</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($content as $item)
                    <tr>
                        <td class="cart_product">
                            <a href=""><img src="{{URL::to('public/uploads/product/'.$item -> options -> image)}}" alt="" width="50"/></a>
                        </td>
                        <td class="cart_description">
                            <h4><a href="">{{$item ->name}}</a></h4>
                            <p>Web ID: {{$item -> id}}</p>
                        </td>
                        <td class="cart_price">
                            <p>{{number_format($item -> price). 'VNĐ'}}</p>
                        </td>
                        <td class="cart_quantity">
                            <form action="{{URL::to('/update-cart-quanlity')}}" method="POST">
                                {{csrf_field()}}
                                <div class="cart_quantity_button">
                          
                                    <input class="cart_quantity_input" type="text" name="cart_quantity" value="{{$item -> qty}}" >
                                    <input type="hidden" value= "{{$item->rowId}}" name="rowId_cart" class="form-control">
                                    <input type="submit" value= "Cập nhật" name="update_qty" class="btn btn-default btn-sm">
                                </div>
                            </form>
                           
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">
                                <?php
                                $subtotal = $item -> price * $item -> qty;
                                echo number_format($subtotal).' VNĐ';
                                ?>
                            </p>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" href="{{URL::to('/delete-to-cart/'.$item->rowId)}}"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                        
                    @endforeach
                   

                
                </tbody>
            </table>
        </div>
        <h4 style="margin:40px 0; font-size: 20px">Chọn phương thức thanh toán</h4>
        <form action="{{URL::to('/order-place')}}" method="POST">
            {{ csrf_field() }}
            <div class="payment-options">
                <span>
                    <label><input name="payment_option" value="1" type="checkbox"> Thanh toán bằng thẻ ATM</label>
                </span>
                <span>
                    <label><input name="payment_option" value="2" type="checkbox"> Thanh toán bằng tiền mặt/label>
                </span>
                <span>
                    <label><input name="payment_option" value="3" type="checkbox"> Thanh toán bằng thẻ ghi nợ</label>
                </span>

                <input type="submit" value= "Đặt hàng" name="send_order_place" class="btn btn-primary btn-sm">
        </div>
        </form>
       
    </div>
</section> <!--/#cart_items-->
@endsection