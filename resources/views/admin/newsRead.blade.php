@extends('/layouts.admin.index')

@section('header')
    <header class="py-5 bg-light border-bottom mb-4" style="background-image: url('{{asset('assets/img/about-bg.jpg')}}')">
        <div class="container">
            <div class="text-center my-5">
                <h1 class="fw-bolder">新聞內容</h1>
                <p class="lead mb-0"></p>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="col-lg-8">
        <!-- Post content-->
        <article>
            <!-- Post header-->
            <header class="mb-4">
                <!-- Post title-->
                <h1 class="fw-bolder mb-1">{{ $new->title }}</h1>
                <!-- Post meta content-->
                <div class="text-muted fst-italic mb-2">Posted on {{ $new->created_at }}</div>
            </header>

            <!-- Post content-->
            <section class="mb-5">
                <p style="white-space: pre-line;" class="fs-5 mb-4">{{ $new->content }}</p>
            </section>
        </article>
        <form method="POST" action="/admin/news/{{ $new->id }}">
            @csrf
            @method('DELETE')
            <a class="btn btn-primary" href="/admin/news/{{ $new->id }}/edit">編輯</a>
            <button type="submit" class="btn btn-primary">刪除</button>
        </form>
    </div>
@endsection