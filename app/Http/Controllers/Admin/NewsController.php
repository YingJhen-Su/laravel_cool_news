<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Models\News;


class NewsController extends Controller
{

    public function __construct()
    {
      $this->categories = Category::all();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $tags = Tag::all();

      $tagUseds = array();
      foreach ($tags as $tag) {
        if (count($tag->news) > 0) {
          $tagUseds[] = $tag;
        }
    }
      $newsCount = News::count();
      $newsPerPage = 3;
      $pageCount = ceil($newsCount / $newsPerPage);
      $currentPage = isset($request->all()['psge']) ? $request->all()['psge'] : 1;

      $news = News::orderBy('created_at', 'desc')
                    ->offset($newsPerPage * ($currentPage-1))
                    ->limit($newsPerPage)
                    ->with(['tags'])
                    ->get();

      $header = "最新發布新聞";

      return view('admin.newsList', [
        'news'        => $news,
        'categories'  => $this->categories,
        'tagUseds'    => $tagUseds,
        'currentPage' => $currentPage,
        'pageCount'   => $pageCount,
        'header'      => $header
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('123');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $validatedData = $this->validateNews($request);

      $news = new News($validatedData);
      $news->user_id = auth()->id();
      $news->save();

      $news->tags()->attach($validatedData['tags']);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $new = News::find($id);
      $tagUseds = $new->tags;
      $header = $new->title;

      return view('admin.newsRead', [
        'new'        => $new,
        'tagUseds'   => $tagUseds,
        'categories' => $this->categories,
        'header'     => $header
      ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $news = News::find($id)->get();
      return view('123', ['news' => $news]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $news = News::find($id);
      $tags = $news->tags;

      $validatedData = $this->validateNews($request);
      $news->update($validatedData);

      $tagChanges = $validatedData['tags'];

      foreach($tagChanges as $tagChange) {
        if (!in_array($tagChange, $tags)) {
          $news->tags()->attach($tagChange);
        }
      }

      foreach ($tags as $tag) {
        if (!in_array($tag, $tagChanges)) {
          $news->tags()->detach($tag);
        }
      }

      return view('123');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      News::find($id)->delete();
      return redirect('123');
    }

    public function validateNews(Request $request)
    {
      return $request->validate([
        'title' => 'required|string',
        'content' => 'required|string',
        'category_id' => 'require|exists:categories,id',
        'tag'      => 'exists:tags,id'
      ]);
    }
}