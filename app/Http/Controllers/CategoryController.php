<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Libraries\Helper;

class CategoryController extends Controller
{
  public function __construct()
  {
    $this->categories = Category::all();
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show(Request $request, $id)
  {
    $newsCount   = Category::find($id)->news()->count();
    $newsPerPage = 3;
    $pageCount   = ceil($newsCount / $newsPerPage);
    $currentPage = isset($request->all()['psge']) ? $request->all()['psge'] : 1;

    $news = Category::find($id)->news()
                                ->with(['tags'])
                                ->orderBy('created_at', 'desc')
                                ->offset($newsPerPage * ($currentPage-1))
                                ->limit($newsPerPage)
                                ->get();

    $tagUseds = Helper::getTagUseds($news);
    $header = Category::find($id)->title."新聞";

    return view('newsList', [
      'news'        => $news,
      'categories'  => $this->categories,
      'tagUseds'    => $tagUseds,
      'currentPage' => $currentPage,
      'pageCount'   => $pageCount,
      'header'      => $header
    ]);
  }
}