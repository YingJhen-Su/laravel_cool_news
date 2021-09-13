<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Tag;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Libraries\Helper;


class NewsController extends Controller
{
    public function __construct()
    {
      $this->categories = Category::all();
      $this->tags = Tag::all();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $newsCount   = News::count();
      $newsPerPage = 3;
      $pageCount   = ceil($newsCount / $newsPerPage);
      $currentPage = isset($request->all()['psge']) ? $request->all()['psge'] : 1;

      $news = News::orderBy('created_at', 'desc')
                    ->offset($newsPerPage * ($currentPage-1))
                    ->limit($newsPerPage)
                    ->with(['tags'])
                    ->get();

      $tagUseds = Helper::getNewsTagUseds($this->tags);
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
      $onenews  = News::find($id);
      $tagUseds = $onenews->tags;

      return view('newsRead', [
        'onenews'    => $onenews,
        'tagUseds'   => $tagUseds,
        'categories' => $this->categories,
        'header'     => '新聞內容'
      ]);
    }
}