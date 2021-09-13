<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Tag;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
      return view('admin.newsCreate', [
        'categories' => $this->categories,
        'tags'       => $this->tags,
        'header'     => '發布新聞'
      ]);
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

      $news->tags()->attach($validatedData['tag_id']);

      return redirect('/admin/news/'.$news->id);
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

      return view('admin.newsRead', [
        'onenews'    => $onenews,
        'tagUseds'   => $tagUseds,
        'categories' => $this->categories,
        'header'     => '新聞內容'
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
      $news = News::find($id);
      $newsTagIds = Helper::getNewsTagIds($news->tags);

      return view('admin.newsEdit', [
        'news'       => $news,
        'categories' => $this->categories,
        'tags'       => $this->tags,
        'newsTagIds' => $newsTagIds,
        'header'     => '編輯新聞'
      ]);
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

      $validatedData = $this->validateNews($request);
      $news->update($validatedData);

      $tagChanges = $validatedData['tag_id'];
      $newsTagIds = Helper::getNewsTagIds($news->tags);

      foreach($tagChanges as $tagChange) {
        if (!in_array($tagChange, $newsTagIds)) {
          $news->tags()->attach($tagChange);
        }
      }

      foreach ($newsTagIds as $newsTagId) {
        if (!in_array($newsTagId, $tagChanges)) {
          $news->tags()->detach($newsTagId);
        }
      }

      return redirect('/admin/news/'.$news->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $news = News::find($id);
      $news->tags()->detach();
      $news->delete();

      return redirect('/admin/news');
    }

    public function validateNews(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'title'       => 'required|string',
        'content'     => 'required|string',
        'category_id' => 'required|exists:categories,id',
        'tag_id'      => 'exists:tags,id'
      ]);

      return $validator->validate();
    }
}