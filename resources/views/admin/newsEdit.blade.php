@extends('/layouts.admin.form')

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
        <header class="mb-4">
            <!-- Post title-->
            <h2>編輯新聞</h2>
        </header>

        <form method="POST" action="/admin/news/{{ $news->id }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">新聞標題：</label>
                <input name="title" type="text" class="form-control @error('title') is-invalid @enderror" id="title" value="{{ $news->title }}">

                @error('title')
                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="content">新聞內容：</label>
                <textarea name="content" class="form-control @error('content') is-invalid @enderror" id="content" rows="10">{{ $news->content }}</textarea>

                @error('content')
                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="category_id">新聞分類：</label>
                @foreach($categories as $category)
                    <div class="form-check form-check-inline @error('category_id') is-invalid @enderror">
                        <input class="form-check-input" type="radio" name="category_id" id="category_id" value="{{ $category->id }}" @if($category->id == $news->category->id) checked @endif>
                        <label class="form-check-label" for="inlineRadio1">{{ $category->title }}</label>
                    </div>
                @endforeach

                @error('category_id')
                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="tag_id">標籤：</label>
                <select class="custom-select  @error('tag_id') is-invalid @enderror" id="tag_id" name="tag_id[]" multiple>
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}" @if(is_array($newsTagIds) && in_array($tag->id, $newsTagIds)) selected @endif>{{ $tag->title }}</option>
                    @endforeach
                </select>

                @error('tag_id')
                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">發布</button>
        </form>
    </div>
@endsection