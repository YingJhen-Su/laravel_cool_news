<?php

namespace App\Http\Libraries;

class Helper
{
  public static function getNewsTagUseds($tags)
  {
    $tagIds = array();
    $tagUseds = array();
    foreach ($tags as $tag) {
      if (count($tag->news) > 0 && !in_array($tag->id, $tagIds)) {
        $tagUseds[] = $tag;
        $tagIds[] = $tag->id;
      }
    }

    return $tagUseds;
  }

  public static function getTagUseds($news)
  {
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

    return $tagUseds;
  }

  public static function getNewsTagIds($tags)
  {
    $newsTagIds = array();
    foreach ($tags as $tag) {
      $newsTagIds[] = $tag->id;
    }

    return $newsTagIds;
  }
}