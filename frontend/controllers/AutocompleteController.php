<?php

namespace frontend\controllers;

use frontend\components\LocationComponent;
use frontend\controllers\parentControllers\SecuredController;
use GuzzleHttp\Client;
use Yii;

class AutocompleteController extends SecuredController
{
    public function actionIndex($address)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (Yii::$app->request->getIsGet()) {

            $client = new Client([
                'base_uri' => 'https://geocode-maps.yandex.ru/',
            ]);

            $query = [
                'apikey' => 'e666f398-c983-4bde-8f14-e3fec900592a',
                'geocode' => $address,
                'format' => 'json',
                'results' => 5
            ];

            $response = $client->request('GET', '1.x', ['query' => $query]);

            $content = $response->getBody()->getContents();

            $response_data = json_decode($content, true);

            $data = [];
            foreach ($response_data['response']['GeoObjectCollection']['featureMember'] as $item) {
                $data[] = ['name' => $item['GeoObject']['metaDataProperty']['GeocoderMetaData']['text']];
            }

            return $data;
        }
    }
}
