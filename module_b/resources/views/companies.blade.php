@extends("layouts.main")

@section("title", "Products")

@section("content")
    <div class="wrapper">
        <h1>Companies</h1>
        <a href="/companies/new" class="link">Create a new company</a>
        <div class="products">
            <table>
                <thead>
                <tr>
                    <td>ID</td>
                    <td>Name</td>
                    <td>Address</td>
                    <td>Phone Number</td>
                    <td>Email</td>
                    <td>Owner Name</td>
                    <td>Owner Number</td>
                    <td>Owner Email</td>
                    <td>Contact Name</td>
                    <td>Contact Number</td>
                    <td>Contact Email</td>
                </tr>
                </thead>
                <tbody>
                @foreach($companies as $item)
                    <tr data-path="companies" data-id="{{$item["id"]}}" class="item {{$item['is_deactivated'] === 1 ? "hidden" : ""}}">
                        @foreach($item as $k => $v)
                            @if(!in_array($k, ["is_deactivated", 'created_at', "updated_at"]))
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
