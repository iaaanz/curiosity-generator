<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Services\TranslateService;
use phpDocumentor\Reflection\PseudoTypes\False_;

class RandomPostController extends Controller
{
  public function GetRandomPost(TranslateService $trans)
  {
    $response = Http::get('https://www.reddit.com/r/todayilearned/random.json');
    $responseBody = json_decode($response->getBody());
    $formatted_data = $responseBody[0]->data->children[0]->data;
    $prefix = substr($formatted_data->title, 0, 4);

    if ($prefix == "TIL ") {
      $title = substr($formatted_data->title, 4);
    } else {
      $title = $formatted_data->title;
    }

    $transData = $trans->translate($title);

    if ($transData == False) {
      echo "vai redirecionar para uma página pedindo pra tentar novamente";
    }

    return compact('transData');
  }
}
