<?php

namespace App\Http\Controllers;

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

      return view('newsList', [
        'news'        => $news,
        'categories'  => $this->categories,
        'tagUseds'    => $tagUseds,
        'currentPage' => $currentPage,
        'pageCount'   => $pageCount,
        'header'      => $header
      ]);
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

      return view('newsRead', [
        'new'        => $new,
        'tagUseds'   => $tagUseds,
        'categories' => $this->categories,
        'header'     => $header
      ]);
    }
}