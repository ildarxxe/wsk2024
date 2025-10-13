@php use Carbon\Carbon; @endphp
@extends('layouts.main')

@section('title', $data['title'])

@section("style")
    <link rel="stylesheet" href="{{asset("css/page.css")}}">
@endsection

@section('meta_tags')
    <meta property="og:title" content="{{ $data['title'] }}">
    <meta property="og:description" content="{{ $data['summary'] }}">
    @if ($data['cover'])
        <meta property="og:image" content="{{ asset('content-pages/images/' . $data['cover']) }}">
    @endif
@endsection

@section('content')
    <div class="cover-image-container">
        <img
            src="{{ asset('/content-pages/images/' . $data['cover']) }}"
            alt="Cover image for {{ $data['title'] }}"
            class="cover-image"
        >
        <div class="spotlight-mask"></div>
    </div>

    <header class="page-header">
        <h1 class="title-heading">{{ $data['title'] }}</h1>
    </header>

    <div class="page-content-wrapper">

        <aside class="aside-meta-info sticky-top">
            <h2>Article Info</h2>

            @if ($data['date'])
                <p><strong>Published Date:</strong> {{ Carbon::parse($data['date'])->format('F d, Y') }}</p>
            @endif

            @if ($data['is_draft'])
                <p class="draft-badge"><strong>🚨 DRAFT! (Not Visible in Listing)</strong></p>
            @endif

            @if (!empty($data['tags']))
                <div class="tags-list">
                    <strong>Tags:</strong>
                    @foreach ($data['tags'] as $tag)
                        <a href="{{ route('heritage.tags', ['tag' => Str::slug($tag)]) }}"
                           class="tag-link">#{{ $tag }}</a>
                    @endforeach
                </div>
            @endif
        </aside>

        <main class="main-article-content">
            {!! $data['render_content'] !!}
        </main>
    </div>

@endsection
