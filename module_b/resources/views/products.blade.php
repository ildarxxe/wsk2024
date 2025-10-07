@extends("layouts.main")
@section("title", "Products")

@section("styles")
    <link rel="stylesheet" href="{{asset('css/products.css')}}">
@endsection

@section("content")
    <div class="products_wrapper">
        <div class="products">
            <h1 class="page_title">Products Management</h1>
            <button class="new_product">Add a new product</button>
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
            <div class="add_form hidden">
                <form action="/products/create" method="POST">
                    <h1>New product</h1>
                    @csrf
                    <div class="form_label">
                        <label for="name">Name:</label>
                        <input required type="text" name="name" id="name">
                    </div>
                    <div class="form_label">
                        <label for="french_name">Name in french:</label>
                        <input required type="text" name="french_name" id="french_name">
                    </div>
                    <div class="form_label">
                        <label for="description">Description:</label>
                        <input required type="text" name="description" id="description">
                    </div>
                    <div class="form_label">
                        <label for="french_description">Description in french:</label>
                        <input required type="text" name="french_description" id="french_description">
                    </div>
                    <div class="form_label">
                        <label for="GTIN">GTIN:</label>
                        <input required type="text" name="GTIN" id="GTIN">
                    </div>
                    <div class="form_label">
                        <label for="brand_name">Brand name:</label>
                        <input required type="text" name="brand_name" id="brand_name">
                    </div>
                    <div class="form_label">
                        <label for="origin_country">Country of origin:</label>
                        <input required type="text" name="origin_country" id="origin_country">
                    </div>
                    <div class="form_label">
                        <label for="gross_weight">Gross weight:</label>
                        <input required type="text" name="gross_weight" id="gross_weight">
                    </div>
                    <div class="form_label">
                        <label for="net_weight">Net content weight:</label>
                        <input required type="text" name="net_weight" id="net_weight">
                    </div>
                    <div class="form_label">
                        <label for="weight_unit">Weight unit:</label>
                        <input required type="text" name="weight_unit" id="weight_unit">
                    </div>
                    <div class="form_button">
                        <button type="submit">Create</button>
                    </div>
                </form>
            </div>
            <div class="products_inner">
                @if(isset($products) && count($products) !== 0)
                    <table>
                        <thead>
                        <tr>
                            <td>GTIN</td>
                            <td>Product name</td>
                            <td>Company name</td>
                            <td>Status</td>
                            <td>Management</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr data-id="{{$product["GTIN"]}}" class="product {{ $product['hidden'] === 1 ? 'hidden-product' : '' }}">
                                <td>{{$product['GTIN']}}</td>
                                <td>{{$product['name']}}</td>
                                <td>{{$product['company_name']}}</td>
                                <td>{{$product['hidden'] === 0 ? "Active" : "Hidden"}}</td>
                                <td><div class="management">
                                        @if($product['hidden'] === 0)
                                            <button class="change_status_btn" data-id="{{$product["GTIN"]}}">Hide</button>
                                        @else
                                            <button class="change_status_btn" data-id="{{$product["GTIN"]}}">Activate</button>
                                        @endif
                                    </div></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="not_found_text">Products not found :(</p>
                @endif
            </div>
        </div>
    </div>
@endsection

@section("script")
    <script src="{{asset('js/products.js')}}"></script>
@endsection
