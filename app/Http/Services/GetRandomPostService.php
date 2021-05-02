<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GetRandomPostService
{
  public function getPost()
  {
    $response = Http::get(config('app.POST_URL'));
    $responseBody = $response->object();
    $unformatted_data = $responseBody[0]->data->children[0]->data;
    $unf_title = $unformatted_data->title;

    if (Str::startsWith($unf_title, ['TIL', 'TIL:', 'TIL '])) {
      $title = Str::of(strstr($unf_title, ' '))
        ->trim()
        ->ucfirst();
    } else {
      $title = Str::ucfirst($unf_title);
    }

    $subreddit_name_prefixed = $unformatted_data->subreddit_name_prefixed;
    $author = $unformatted_data->author;
    $thumbnail = $unformatted_data->thumbnail;
    $info_url = $unformatted_data->url;
    $original_post = 'https://www.reddit.com' . $unformatted_data->permalink;

    $rand_post = [
      'author' => $author,
      'subreddit_name_prefixed' => $subreddit_name_prefixed,
      'original_post' => $original_post,
      'unformatted_text' => $unformatted_data->title,
      'formatted_text' => strval($title),
      'thumbnail' => $thumbnail,
      'info_url' => $info_url
    ];

    return response()->json($rand_post);
  }
}
