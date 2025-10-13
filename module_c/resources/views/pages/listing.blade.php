@extends('layouts.main')

@section("title", "listing")

@section("style")
    <link rel="stylesheet" href="{{asset("css/listing.css")}}">
@endsection

@section("content")
    <div class="listing-container">
        @foreach($items as $item)
            <div class="listing-item folder">
                @if ($item['type'] === 'folder')
                    <a href="{{ route('heritage.path', ['path' => $item['path_slug']]) }}">
                        📁 {{ $item['name'] }}
                    </a>
                @else
                    <a href="{{ route('heritage.path', ['path' => $item['path_slug']]) }}">
                        <h3>{{ $item['title'] }}</h3>
                        <p>{{ $item['summary'] }}</p>
                    </a>
                    <small>Дата: {{ $item['date'] }}</small>
                @endif
            </div>
        @endforeach
    </div>
@endsection
