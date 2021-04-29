<?php

namespace App\Http\Services;

class TranslateService
{
  public function translate($json_post)
  {
    $post = json_decode($json_post);

    $curl = curl_init();

    curl_setopt_array($curl, [
      CURLOPT_URL => config('app.TRANS_URL'),
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "[\r
        {\r
          \"Text\": \"" . $post->title . "\"\r
        }\r
    ]",
      CURLOPT_HTTPHEADER => [
        "content-type: application/json",
        "x-rapidapi-host: microsoft-translator-text.p.rapidapi.com",
        "x-rapidapi-key:" . env('rapidapi_key')
      ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    }

    $responseBody = json_decode($response);

    if (!is_array($responseBody)) {
      return false;
    }

    $obj_text = $responseBody[0]->translations[0]->text;
    $trans_text = strval($obj_text);

    $json_text = [
      'text' => $trans_text,
    ];

    return $json_text;
  }
}
