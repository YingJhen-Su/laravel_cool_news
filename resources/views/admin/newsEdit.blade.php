@extends('/layouts.admin.form')

@section('header')
    <header class="py-5 bg-light border-bottom mb-4" style="background-image: url('{{asset('assets/img/about-bg.jpg')}}')">
        <div class="container">
            <div class="text-center my-5">
                <h1 class="fw-bolder">Welcome to Blog Post!</h1>
                <p class="lead mb-0">Posted on January 1, 2021 by Start Bootstrap</p>
            </div>
        </div>
    </header>
@endsection


@section('content')
    <div class="col-lg-8">
        <header class="mb-4">
            <!-- Post title-->
            <h2>發布新聞</h2>
        </header>

        <form method="POST" action="admin/news/create">
            @csrf

            <div class="form-group">
                <label for="title">新聞標題：</label>
                <input type="title" class="form-control @error('title') is-invalid @enderror" id="title">

                @error('title')
                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="content">新聞內容：</label>
                <textarea name="content" class="form-control @error('content') is-invalid @enderror" id="content" rows="10">{{ old('content') }}</textarea>

                @error('content')
                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                @enderror
            </div>

            <label for="category_id">新聞分類：</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="category_id" id="category_id" value="#">
                <label class="form-check-label" for="inlineRadio1">全球</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="category_id" id="category_id" value="#">
                <label class="form-check-label" for="inlineRadio2">社會</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="category_id" id="category_id" value="#">
                <label class="form-check-label" for="inlineRadio3">運動</label>
            </div>

            @error('category_id')
            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
            @enderror
            <div class="form-group">
                <label class="my-1 mr-2" for="tags">標籤：</label>
                <select class="custom-select" id="tags" multiple>
                    <option value="#">阿富汗</option>
                    <option value="#">covid-19</option>
                    <option value="#">疫苗</option>
                    <option value="#">颱風</option>
                    <option value="#">舉重</option>
                    <option value="#">桌球</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">發布</button>
        </form>
    </div>
@endsection