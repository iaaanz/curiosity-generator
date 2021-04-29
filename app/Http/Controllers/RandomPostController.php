<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Services\TranslateService;
use App\Http\Services\GetRandomPostService;
use App\Http\Services\PhraseAdjusmentService;

class RandomPostController extends Controller
{

  private $TransService;
  private $PostService;
  private $PhraseService;

  public function __construct(
    TranslateService $TransService,
    GetRandomPostService $PostService,
    PhraseAdjusmentService $PhraseService
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
      echo "TODO: vai redirecionar para uma página pedindo pra tentar novamente (erro na API)";
    }



    return $trans_post;
  }
}
