@extends('layouts.index')

@section('header')
<header class="py-5 bg-light border-bottom mb-4" style="background-image: url('{{asset('assets/img/about-bg.jpg')}}')">
    <div class="container">
        <div class="text-center my-5">
            <h1 class="fw-bolder">{{ $header }}</h1>
            <p class="lead mb-0"></p>
        </div>
    </div>
</header>
@endsection

@section('content')
<div class="col-lg-8">
    <!-- Featured blog post-->
    @foreach($news as $new)
        <div class="card mb-4">
            <div class="card-body">
                <div class="small text-muted">{{ $new->created_at }}</div>
                <a href="/news/{{ $new->id }}">
                    <h2 class="card-title">{{ $new->title }}</h2>
                </a>
                <p class="card-text">{{ $new->short_content }}</p>
                @foreach($new->tags as $tag)
                    <a class="badge bg-secondary text-decoration-none link-light" href="/tags/{{ $tag->id }}">{{ $tag->title }}</a>
                @endforeach
            </div>
        </div>
    @endforeach

    <!-- Pagination-->
    <nav aria-label="Pagination">
        <hr class="my-0" />
        <ul class="pagination justify-content-center my-4">
            <li class="page-item @if ($currentPage == 1) disabled @endif"><a class="page-link" href="/news?page={{ $currentPage-1 }}" tabindex="-1" aria-disabled="true">Newer</a></li>
            @for ($i = 1 ; $i <= $pageCount ; $i++)
                <li class="page-item @if ($i == $currentPage) active @endif" aria-current="page"><a class="page-link" href="/news?page={{ $i }}">1</a></li>
            @endfor
            <li class="page-item @if ($currentPage == $pageCount) disabled @endif"><a class="page-link" href="/news?page={{ $currentPage+1 }}">Older</a></li>
        </ul>
    </nav>
</div>
@endsection