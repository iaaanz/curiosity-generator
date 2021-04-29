<?php

namespace App\Http\Services;

use Illuminate\Support\Str;

class PhraseAdjusmentService
{
  public function phraseAdjusment($post)
  {
    $phrase_init = strstr($post->title, ' ', true);

    if (Str::of($phrase_init)->startsWith(['que', 'til'])) {
      dd('começa com QUE ou TIL');
    }

    return;
  }
}
