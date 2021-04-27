<?php

namespace App\Http\Services;

class TranslateService
{
  public function translate($title)
  {

    $curl = curl_init();

    curl_setopt_array($curl, [
      CURLOPT_URL => "https://microsoft-translator-text.p.rapidapi.com/translate?to=pt-br&api-version=3.0&from=en&profanityAction=NoAction",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "[\r
        {\r
          \"Text\": \"" . $title . "\"\r
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

    $obj_title = $responseBody[0]->translations[0]->text;
    $trans_title = strval($obj_title);

    return compact('trans_title');
  }
}
