<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Category;
use App\Http\Libraries\Helper;

class TagController extends Controller
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
    $newsCount   = Tag::findOrFail($id)->news()->count();
    $newsPerPage = 3;
    $pageCount   = ceil($newsCount / $newsPerPage);
    $currentPage = isset($request->all()['page']) ? $request->all()['page'] : 1;

    $news = Tag::findOrFail($id)->news()
                                ->orderBy('created_at', 'desc')
                                ->offset($newsPerPage * ($currentPage-1))
                                ->limit($newsPerPage)
                                ->get();

    $tagUseds = Helper::getTagUseds($news);
    $header = Tag::find($id)->title."ηΈιζ°θ";

    return view('admin.newsList', [
      'news'        => $news,
      'categories'  => $this->categories,
      'tagUseds'    => $tagUseds,
      'currentPage' => $currentPage,
      'pageCount'   => $pageCount,
      'header'      => $header
    ]);
  }
}