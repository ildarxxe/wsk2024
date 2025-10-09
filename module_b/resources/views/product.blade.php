@extends("layouts.main")

@section("title", "Product Page")

@section("content")
    <div class="wrapper">
        <h1>{{$product['name']}}</h1>
        <div class="company">
            <div class="img_management">
                <button data-id="{{$product['GTIN']}}" class="delete_image">Delete image</button>
                <div class="form_label">
                    <label for="file">Select a image for product</label>
                    <input data-id="{{$product['GTIN']}}" type="file" name="file" id="file">
                </div>
            </div>
            <img src="{{$product['image_url']}}" alt="product image">
            <form class="edit_form hidden" method="POST" action="/products/{{$product['GTIN']}}/edit">
                @csrf

                @foreach($product as $k => $v)
                    @if(!in_array($k, ["GTIN", "company_id", 'company', "image_url", "is_hidden", "created_at", "updated_at", "id"]))
                        <div class="form_label">
                            <label for="{{$k}}">{{str_replace("_", " ", $k)}}:</label>
                            <input type="text" value="{{$v}}" name="{{$k}}" id="{{$k}}">
                        </div>
                    @endif
                @endforeach

                <div class="form_button">
                    <button type="submit">Save</button>
                </div>
            </form>
            <div class="management">
                @if($product['is_hidden'] === 0)
                    <button class="hide change_status" data-path="products" data-id="{{$product['GTIN']}}">Hide</button>
                @else
                    <h2>Hidden</h2>
                    <button class="delete" data-id="{{$product['GTIN']}}">Delete a product</button>
                @endif
                <button class="edit" data-id="{{$product['GTIN']}}">Edit</button>
            </div>
            <div class="info">
                @foreach($product as $k => $v)
                    @if(!in_array($k, ["image_url", 'company', "is_hidden", "created_at", "updated_at", "id"]))
                        <div class="info_box">
                            <h2>{{str_replace("_", " ", $k)}}:</h2>
                            <p>{{$v}}</p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection
@section("script")
    <script src="{{asset("js/script.js")}}"></script>
@endsection
