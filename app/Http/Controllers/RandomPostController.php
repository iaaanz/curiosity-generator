<?php

namespace App\Http\Controllers;

use App\Http\Services\TranslateService;
use App\Http\Services\GetRandomPostService;
use App\Http\Services\PhraseAdjustmentService;

class RandomPostController extends Controller
{
  private $TransService;
  private $PostService;
  private $PhraseService;

  public function __construct(
    TranslateService $TransService,
    GetRandomPostService $PostService,
    PhraseAdjustmentService $PhraseService
  ) {
    $this->TransService = $TransService;
    $this->PostService = $PostService;
    $this->PhraseService = $PhraseService;
  }

  public function RandomPost()
  {
    $rand_post = $this->PostService->getPost();
    $trans_post = $this->TransService->translate($rand_post);

    if ($trans_post == False) {
      return response()->json([
        'error' => 'Erro na API'
      ]);
    }

    $filtered_phrase = $this->PhraseService->phraseAdjusment($trans_post);

    $rand_post = $rand_post->getData();
    $rand_post->final_text = $filtered_phrase->getData()->final_text;

    return response()->json($rand_post);
  }
}
