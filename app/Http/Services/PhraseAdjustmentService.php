<?php

namespace App\Http\Services;

use Illuminate\Support\Str;

class PhraseAdjustmentService
{
  public function phraseAdjusment($json_post)
  {
    $post = $json_post->getData();

    if (Str::startsWith($post->text, ['Que', 'que', 'Do', 'do', 'til', 'TIL', 'TIL:'])) {
      $filtered_word = Str::of(strstr($post->text, ' '))
        ->trim()
        ->ucfirst();
    } else {
      $filtered_word = Str::ucfirst($post->text);
    }

    return response()->json([
      'final_text' => strval($filtered_word)
    ]);
  }
}
