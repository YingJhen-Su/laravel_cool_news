@extends('/layouts.admin.index')

@section('content-part')
<div class="col-lg-8">
    <!-- Featured blog post-->
    @foreach($news as $onenews)
        <div class="card mb-4">
            <div class="card-body">
                <div class="small text-muted">{{ $onenews->created_at }}</div>
                <a href="/admin/news/{{ $onenews->id }}">
                    <h2 class="card-title">{{ $onenews->title }}</h2>
                </a>
                <p class="card-text">{{ $onenews->short_content }}</p>
                @foreach($onenews->tags as $tag)
                    <a class="badge bg-secondary text-decoration-none link-light" href="/admin/tags/{{ $tag->id }}">{{ $tag->title }}</a>
                @endforeach
                <form method="POST" action="/admin/news/{{ $onenews->id }}">
                    @csrf
                    @method('DELETE')
                    <a class="btn btn-primary" href="/admin/news/{{ $onenews->id }}/edit">編輯</a>
                    <button type="submit" class="btn btn-primary">刪除</button>
                </form>
            </div>
        </div>
    @endforeach

    <!-- Pagination-->
    <nav aria-label="Pagination">
        <hr class="my-0" />
        <ul class="pagination justify-content-center my-4">
            <li class="page-item @if ($currentPage == 1) disabled @endif"><a class="page-link" href="/admin/news?page={{ $currentPage-1 }}" tabindex="-1" aria-disabled="true">Newer</a></li>
            @for ($i = 1 ; $i <= $pageCount ; $i++)
                <li class="page-item @if ($i == $currentPage) active @endif" aria-current="page"><a class="page-link" href="/admin/news?page={{ $i }}">{{ $i }}</a></li>
            @endfor
            <li class="page-item @if ($currentPage == $pageCount) disabled @endif"><a class="page-link" href="/admin/news?page={{ $currentPage+1 }}">Older</a></li>
        </ul>
    </nav>
</div>
@endsection