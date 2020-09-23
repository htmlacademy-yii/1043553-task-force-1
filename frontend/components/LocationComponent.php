<?php

namespace frontend\components;

use GuzzleHttp\Client;

class LocationComponent
{
    private Client $client;
    private \Psr\Http\Message\ResponseInterface $response;
    private $responseData;
    private string $address;

    private const LOCATION_EXCEPTION = 'Введите валидный адрес. Невозможно определить координаты';

    public function __construct(string $address)
    {
        $this->client = new Client([
            'base_uri' => 'https://geocode-maps.yandex.ru/',
        ]);

        $this->address = $address;
    }

    public function getCoordinates(): array
    {
        $this->sendRequest(1);

        $this->getResponse();

        $coordinates = $this->responseData
            ['response']['GeoObjectCollection']['featureMember']['0']['GeoObject']['Point']['pos'] ?? null;

        if ($coordinates) {
            $coordinates = explode(' ', $coordinates);

            return ['lat' => $coordinates[1], 'lon' => $coordinates[0]];
        }

        throw new \Exception(self::LOCATION_EXCEPTION);
    }

    private function sendRequest(int $results): void
    {
        $query = [
            'apikey' => 'e666f398-c983-4bde-8f14-e3fec900592a',
            'geocode' => $this->address,
            'format' => 'json',
            'results' => $results
        ];

        $this->response = $this->client->request('GET', '1.x', ['query' => $query]);
    }

    private function getResponse(): void
    {
        $content = $this->response->getBody()->getContents();

        $this->responseData = json_decode($content, true);
    }
}
