@extends("layouts.main")
@section("title", "Products")

@section("styles")
    <link rel="stylesheet" href="{{asset('css/products.css')}}">
@endsection

@section("content")
    <div class="products_wrapper">
        <div class="products">
            <h1 class="page_title">Products Management</h1>
            <a class="new_product" href="/products/new">Add a new product</a>
            <div class="errors_wrapper"></div>
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
