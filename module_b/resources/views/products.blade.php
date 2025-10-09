@extends("layouts.main")

@section("title", "Products")

@section("content")
    <div class="wrapper">
        <h1>Products</h1>
        <a href="/products/new" class="link">Create a new product</a>
        <div class="products">
            <table>
                <thead>
                <tr>
                    <td>GTIN</td>
                    <td>Name</td>
                    <td>Name in French</td>
                    <td>Description</td>
                    <td>Description in French</td>
                    <td>Brand Name</td>
                    <td>Country Of Origin</td>
                    <td>Gross Weight</td>
                    <td>Net Content Weight</td>
                    <td>Weight Unit</td>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $item)
                    <tr data-path="products" data-id="{{$item["GTIN"]}}" class="item {{$item['is_hidden'] === 1 ? "hidden" : ""}}">
                        @foreach($item as $k => $v)
                            @if(!in_array($k, ["image_url", 'company', "company_id", "is_hidden", 'created_at', "updated_at"]))
                                <td>{{$v}}</td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section("script")
    <script src="{{asset("js/script.js")}}"></script>
@endsection
