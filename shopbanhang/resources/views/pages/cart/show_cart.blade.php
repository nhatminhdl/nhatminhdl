@extends('welcome')
@section('content')

<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="#">Trang chủ</a></li>
              <li class="active">Giỏ hàng của bạn</li>
            </ol>
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
    </div>
</section> <!--/#cart_items-->

<section id="do_action">
    <div class="container">
        <div class="heading">
            <h3>What would you like to do next?</h3>
            <p>Choose if you have a discount code or reward points you want to use or would like to estimate your delivery cost.</p>
        </div>
        <div class="row">
            {{-- <div class="col-sm-6">
                <div class="chose_area">
                    <ul class="user_option">
                        <li>
                            <input type="checkbox">
                            <label>Use Coupon Code</label>
                        </li>
                        <li>
                            <input type="checkbox">
                            <label>Use Gift Voucher</label>
                        </li>
                        <li>
                            <input type="checkbox">
                            <label>Estimate Shipping & Taxes</label>
                        </li>
                    </ul>
                    <ul class="user_info">
                        <li class="single_field">
                            <label>Country:</label>
                            <select>
                                <option>United States</option>
                                <option>Bangladesh</option>
                                <option>UK</option>
                                <option>India</option>
                                <option>Pakistan</option>
                                <option>Ucrane</option>
                                <option>Canada</option>
                                <option>Dubai</option>
                            </select>
                            
                        </li>
                        <li class="single_field">
                            <label>Region / State:</label>
                            <select>
                                <option>Select</option>
                                <option>Dhaka</option>
                                <option>London</option>
                                <option>Dillih</option>
                                <option>Lahore</option>
                                <option>Alaska</option>
                                <option>Canada</option>
                                <option>Dubai</option>
                            </select>
                        
                        </li>
                        <li class="single_field zip-field">
                            <label>Zip Code:</label>
                            <input type="text">
                        </li>
                    </ul>
                    <a class="btn btn-default update" href="">Get Quotes</a>
                    <a class="btn btn-default check_out" href="">Continue</a>
                </div>
            </div> --}}
            <div class="col-sm-6">
                <div class="total_area">
                    <ul>
                        <li>Tổng<span>{{Cart::subtotal(0,',','.').' VNĐ'}}</span></li>
                        <li>Thuế<span>{{Cart::tax(0,',','').' VNĐ'}}</span></li>
                        <li>Phí vận chuyển<span>Free</span></li>
                        <li>Tổng thanh toán<span>{{Cart::total(0,',','.').' VNĐ'}}</span></li>
                    </ul>
                        {{-- <a class="btn btn-default update" href="">Update</a> --}}
                        <?php
                        $customer_id = Session::get('customer_id');
                        if ($customer_id != null) {
                        ?>
                        <li><a href="{{URL::to('/checkout')}}"><i class="fa fa-crosshairs"></i> Thanh toán</a></li>;
                        <?php
                        }else{
                        ?>
                        <li><a href="{{URL::to('/login-checkout')}}"><i class="fa fa-crosshairs"></i> Thanh toán</a></li>
                        
                        <?php
                        }?>
                </div>
            </div>
        </div>
    </div>
</section><!--/#do_action-->
@endsection