<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;

class GetRandomPostService
{
  public function getPost()
  {
    $response = Http::get(config('app.POST_URL'));
    $responseBody = json_decode($response->getBody());
    $formatted_data = $responseBody[0]->data->children[0]->data;
    $prefix = substr($formatted_data->title, 0, 4);

    if ($prefix == "TIL ") {
      $title = substr($formatted_data->title, 4);
    } else {
      $title = $formatted_data->title;
    }

    $rand_post = [
      'title' => $title
    ];

    return json_encode($rand_post);
  }
}
