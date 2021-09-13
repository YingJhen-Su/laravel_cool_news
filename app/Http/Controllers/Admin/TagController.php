<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Category;

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
    $newsCount = Tag::find($id)->news()->count();
    $newsPerPage = 3;
    $pageCount = ceil($newsCount / $newsPerPage);
    $currentPage = isset($request->all()['psge']) ? $request->all()['psge'] : 1;

    $news = Tag::find($id)->news()
                          ->with(['tags'])
                          ->orderBy('created_at', 'desc')
                          ->offset($newsPerPage * ($currentPage-1))
                          ->limit($newsPerPage)
                          ->get();

    $tagIds = array();
    $tagUseds = array();
    foreach ($news as $new){
      foreach ($new->tags as $tag) {
        if (!in_array($tag->id, $tagIds)) {
          $tagUseds[] = $tag;
          $tagIds[] = $tag->id;
        }
      }
    }

    $header = Tag::find($id)->title."相關新聞";

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