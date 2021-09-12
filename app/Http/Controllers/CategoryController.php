<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show(Request $request, $id)
  {
    $newsCount = Category::find($id)->news()->count();
    $newsPerPage = 5;
    $pageCount = ceil($newsCount / $newsPerPage);
    $currentPage = isset($request->all()['psge']) ? $request->all()['psge'] : 1;

    $news = Category::find($id)->news()
                                ->with(['tags'])
                                ->orderBy('created_at', 'desc')
                                ->offset($newsPerPage * ($currentPage-1))
                                ->limit($newsPerPage)
                                ->get();

    return view('123', [
      'news' => $news,
      'newsCount' => $newsCount,
      'pageCount' => $pageCount
    ]);
  }
}