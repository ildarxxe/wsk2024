@extends("layouts.main")

@section("title", "Company Page")

@section("content")
    <div class="wrapper">
        <h1>{{$company['name']}}</h1>
        <div class="company">
            <form class="edit_form hidden" method="POST" action="/companies/{{$company['id']}}/edit">
                @csrf

                @foreach($company as $k => $v)
                    @if(!in_array($k, ["products", "is_deactivated", "created_at", "updated_at", "id"]))
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
                @if($company['is_deactivated'] === 0)
                    <button class="deactivate change_status" data-path="companies" data-id="{{$company['id']}}">Deactivate</button>
                @else
                    <h2>Deactivated</h2>
                @endif
                <button class="edit" data-id="{{$company['id']}}">Edit</button>
            </div>
            <div class="info">
                @foreach($company as $k => $v)
                    @if(!in_array($k, ["products", "is_deactivated", "created_at", "updated_at", "id"]))
                        <div class="info_box">
                            <h2>{{str_replace("_", " ", $k)}}:</h2>
                            <p>{{$v}}</p>
                        </div>
                    @endif
                @endforeach
            </div>
            <h1>Products</h1>
            <div class="info">
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
                        @foreach($company['products'] as $item)
                            <tr data-path="products" data-id="{{$item["GTIN"]}}" class="item {{$item['is_hidden'] === 1 ? "hidden" : ""}}">
                                @foreach($item as $k => $v)
                                    @if(!in_array($k, ["image_url", "company_id", "is_hidden", 'created_at', "updated_at"]))
                                        <td>{{$v}}</td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section("script")
    <script src="{{asset("js/script.js")}}"></script>
@endsection
