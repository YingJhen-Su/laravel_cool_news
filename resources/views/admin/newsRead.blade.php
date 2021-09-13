@extends('/layouts.admin.index')

@section('content-part')
<div class="col-lg-8">
    <!-- Post content-->
    <article>
        <!-- Post header-->
        <header class="mb-4">
            <!-- Post title-->
            <h1 class="fw-bolder mb-1">{{ $onenews->title }}</h1>
            <!-- Post meta content-->
            <div class="text-muted fst-italic mb-2">Posted on {{ $onenews->created_at }}</div>
        </header>

        <!-- Post content-->
        <section class="mb-5">
            <p style="white-space: pre-line;" class="fs-5 mb-4">{{ $onenews->content }}</p>
        </section>
    </article>
    <form method="POST" action="/admin/news/{{ $onenews->id }}">
        @csrf
        @method('DELETE')
        <a class="btn btn-primary" href="/admin/news/{{ $onenews->id }}/edit">編輯</a>
        <button type="submit" class="btn btn-primary">刪除</button>
    </form>
</div>
@endsection