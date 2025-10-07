@extends("layouts.main")
@section("title", "Product page")

@section("styles")
    <link rel="stylesheet" href="{{asset('css/product.css')}}">
@endsection

@section("content")
    <div class="product_wrapper">
        <div class="errors_wrapper">
            @if(session("error"))
                <p>{{session("error")}}</p>
            @endif
        </div>
        <div class="messages_wrapper">
            @if(session("success"))
                <p>{{session("success")}}</p>
            @endif
        </div>
        <div class="product">
            <div class="page_title">{{$product['name']}}</div>
            <div class="product_management">
                <button class="edit">Edit a product</button>
                <button data-gtin="{{$product['GTIN']}}" id="del_prod" class="delete_img">Delete a product</button>
            </div>
            <div class="edit_form hidden">
                <form method="POST" action="/products/{{$product['GTIN']}}/edit">
                    <h1>Edit form</h1>
                    @csrf
                    @foreach($product as $key => $value)
                        @if (!in_array($key, ['GTIN', 'created_at', 'updated_at', "company_id", "image_url", 'hidden', 'company', "company_name"]))
                            <div class="form_label">
                                <label for="{{$key}}">{{$key}}:</label>
                                <input type="text" name="{{$key}}" id="{{$key}}" value="{{$value}}">
                            </div>
                        @endif
                    @endforeach
                    <div class="form_button">
                        <button type="submit">Save</button>
                    </div>
                </form>
            </div>
            <div class="product_inner">
                <img src="{{$product['image_url'] === null ? "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR7ZtAXM21fycsRNT6V0p0ogIz2s_DRQemKsg&s" : $product['image_url']}}" alt="product image">
                <div class="image_management">
                    <div class="form_label">
                        <label for="image">Select a image</label>
                        <input type="file" name="image" id="image">
                    </div>
                    <button data-gtin="{{$product['GTIN']}}" id="del_img" class="delete_img">Delete a image</button>
                </div>
                <div class="product_info">
                    <div class="box">
                        <h2>Company name:</h2>
                        <p>{{isset($product['company_name']) ? $product['company_name'] : "No company"}}</p>
                    </div>
                    <div class="box">
                        <h2>Brand name:</h2>
                        <p>{{$product['brand_name']}}</p>
                    </div>
                    <div class="box">
                        <h2>Origin country:</h2>
                        <p>{{$product['origin_country']}}</p>
                    </div>
                    <div class="box">
                        <h2>French name:</h2>
                        <p>{{$product['french_name']}}</p>
                    </div>
                    <div class="box">
                        <h2>Description:</h2>
                        <p>{{$product['description']}}</p>
                    </div>
                    <div class="box">
                        <h2>French description:</h2>
                        <p>{{$product['french_description']}}</p>
                    </div>
                    <div class="box">
                        <h2>Product Gross Weight:</h2>
                        <p>{{$product['gross_weight']}}</p>
                    </div>
                    <div class="box">
                        <h2>Product Net Content Weight:</h2>
                        <p>{{$product['net_weight']}}</p>
                    </div>
                    <div class="box">
                        <h2>Product Weight Unit:</h2>
                        <p>{{$product['weight_unit']}}</p>
                    </div>
                    <div class="box">
                        <h2>Status:</h2>
                        <p>{{$product['hidden'] === 0 ? "Active" : "Hidden"}}</p>
                    </div>
                    @if(isset($product['company']))
                        <div class="box">
                            <h1>Contacts:</h1>
                            <div class="in_box">
                                <h2>Telephone number:</h2>
                                <p>{{$product['company']['telephone_number']}}</p>
                            </div>
                            <div class="in_box">
                                <h2>Email:</h2>
                                <p>{{$product['company']['email']}}</p>
                            </div>
                            <div class="in_box">
                                <h2>Owner mobile number:</h2>
                                <p>{{$product['company']['owner_mobile_number']}}</p>
                            </div>
                            <div class="in_box">
                                <h2>Owner email:</h2>
                                <p>{{$product['company']['owner_email_address']}}</p>
                            </div>
                            <div class="in_box">
                                <h2>Contact name:</h2>
                                <p>{{$product['company']['contact_name']}}</p>
                            </div>
                            <div class="in_box">
                                <h2>Contact mobile number:</h2>
                                <p>{{$product['company']['contact_mobile_number']}}</p>
                            </div>
                            <div class="in_box">
                                <h2>Contact email:</h2>
                                <p>{{$product['company']['contact_email_address']}}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section("script")
    <script src="{{asset('js/product.js')}}"></script>
@endsection
