<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Test Affise API</title>
</head>
<body>

  <!-- Вывод информации об оффере -->
  <?php
    require_once 'countrycode.php';
    require_once 'config.php';
    
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => "http://api.cpanomer1.affise.com/3.0/offer/660",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "API-key: " . API_KEY,
      ),
    ));

    $offers = json_decode(curl_exec($curl));
    curl_close($curl);
  ?>
  <h2>Наименование оффера: <? echo $offers->offer->title; ?></h2>
  <h3>Id: <? echo $offers->offer->id; ?></h3>
  <b>Страны, доступные в оффере:</b>
  <ul>
    <?php foreach($offers->offer->countries as $country): ?>
      <li><? echo code_to_country($country); ?></li>
    <?php endforeach; ?>
  </ul>
  </br>
  </br>

  <!-- Вывод информации о конверсии -->
  <?php
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "http://api.cpanomer1.affise.com/3.0/stats/conversions?date_from=2020-01-01&date_to=2020-08-07&limit=1",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "API-key: " . API_KEY,
    ),
  ));

  $conv = json_decode(curl_exec($curl));
  $cc = $conv->conversions[0];
  curl_close($curl);
  ?>
  <h2>Конверсия</h2>
  <h3>ID: <? echo $cc->id; ?></h3>
  <h3>Создана: <? echo $cc->created_at; ?></h3>
  </br>

  <!-- Проверка принадлежности к офферу -->
  <?php if($cc->offer->id == $offers->offer->id):  ?>
    <h3>Проверка - Принадлежит офферу <? echo $offers->offer->id; ?></h3>
    <h4>ClickID: <? echo $cc->cbid; ?></h4>
    <h4>Страна: <? echo $cc->country_name; ?></h4>
    <h4>Город: <? echo $cc->city; ?></h4>
    <h4>IP: <? echo $cc->ip; ?></h4>
  <?php else: ?>
    <h3>Проверка - Не принадлежит офферу <? echo $offers->offer->id; ?></h3>
  <?php endif; ?>
</body>
</html>