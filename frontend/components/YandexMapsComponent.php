<?php

namespace frontend\components;

use GuzzleHttp\Client;

class YandexMapsComponent
{
    private Client $client;
    private \Psr\Http\Message\ResponseInterface $response;
    private $responseData;
    private string $address;
    private string $addressMd5;

    private const LOCATION_EXCEPTION = 'Введите валидный адрес. Невозможно определить координаты';
    public const YANDEX_MAPS_API_KEY = 'e666f398-c983-4bde-8f14-e3fec900592a';
    public const YANDEX_MAPS_BASE_URI = 'https://geocode-maps.yandex.ru/';

    public function __construct(?string $address)
    {
        $this->client = new Client([
            'base_uri' => self::YANDEX_MAPS_BASE_URI,
        ]);
        $this->address = $address ?? '';
        $this->addressMd5 = md5($this->address);
    }

    public function getCoordinates(): array
    {
        $cachedCoordinates = $this->getCoordinatesFromCache();

        return $cachedCoordinates ?? $this->getCoordinatesFromApi();
    }

    private function getCoordinatesFromApi(): array
    {
        $this->sendRequest(1);
        $this->getResponse();

        $coordinates = $this->findCoordinates($this->responseData['0']);
        \Yii::$app->cache->set($this->addressMd5, $coordinates, 86400);

        return $coordinates;
    }

    private function getCoordinatesFromCache(): ?array
    {
        $cachedCoordinates = \Yii::$app->cache->get($this->addressMd5);
        if ($cachedCoordinates) {
            return $cachedCoordinates;
        }

        return null;
    }

    private function findCoordinates($data): array
    {
        $coordinates = $data['GeoObject']['Point']['pos'] ?? null;

        if ($coordinates) {
            $coordinates = explode(' ', $coordinates);

            return ['lat' => $coordinates[1], 'lon' => $coordinates[0]];
        }

        throw new \Exception(self::LOCATION_EXCEPTION);
    }

    public function getAutocompleteValues(): array
    {
        $this->sendRequest(5);
        $this->getResponse();

        return $this->findAutoCompleteValues();
    }

    private function findAutoCompleteValues()
    {
        $data = [];
        foreach ($this->responseData as $location) {
            $address = $location['GeoObject']['metaDataProperty']['GeocoderMetaData']['text'] ?? '';
            try {
                $data[] = [
                    'address' => $address,
                    'coordinates' => $this->findCoordinates($location)
                ];
            } catch (\Exception $e) {
                $data[] = [
                    'address' => $address,
                    'coordinates' => ['lat' => null, 'lon' => null]
                ];
            }
        }

        return $data;
    }

    private function sendRequest(int $results): void
    {
        $query = [
            'apikey' => self::YANDEX_MAPS_API_KEY,
            'geocode' => $this->address,
            'format' => 'json',
            'results' => $results
        ];

        $this->response = $this->client->request('GET', '1.x', ['query' => $query]);
    }

    private function getResponse(): void
    {
        $content = $this->response->getBody()->getContents();
        $responseData = json_decode($content, true);
        $this->responseData = $responseData['response']['GeoObjectCollection']['featureMember'] ?? [];
    }
}
