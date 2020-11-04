<?php

namespace frontend\components;

use yii\authclient\OAuth2;
use GuzzleHttp\Client;

//class VkComponent extends OAuth2
class VkComponent
{
    public const CLIENT_ID = 7642898;
    private const REDIRECT_URI = 'http://localhost:8888/vk-login/';
    public const CLIENT_SECRET = 'oIgvSc6z2ev4YAJMCvDR';

    public const AUTH_URL = 'https://oauth.vk.com/authorize?' .
    'client_id=' . self::CLIENT_ID .
    '&display=page&redirect_uri=' . self::REDIRECT_URI .
    '&scope=email&response_type=code&v=5.124';

    private const BASE_TOKEN_URL = 'https://oauth.vk.com/access_token?' .
    'client_id=' . self::CLIENT_ID .
    '&client_secret=' . self::CLIENT_SECRET .
    '&redirect_uri=' . self::REDIRECT_URI .
    '&code=';

    public string $authUrl = self::AUTH_URL;
    public string $tokenUrl;
    public string $apiBaseUrl = 'https://api.vk.com/method/users.get';

    private string $vkCode;
    private string $vkAccessToken;
    private string $vkUserId;
    private string $vkUserEmail;

    private Client $client;

    public function __construct(string $code, $config = [])
    {
        //parent::__construct($config);

        $this->client = new Client();
        $this->vkCode = $code;
    }

    public function authorizeUserThroughVkAndGetInfo(): array
    {
        return $this->getVkAccessToken()->getVkUserInfo();
    }

    private function getVkAccessToken(): VkComponent
    {
        $this->setTokenUrl();

        $responseData = $this->sendRequestAndGetResponse($this->tokenUrl);
        $this->vkAccessToken = $responseData["access_token"];
        $this->vkUserId = $responseData["user_id"];
        $this->vkUserEmail = $responseData["email"];
        return $this;
    }

    private function getVkUserInfo(): array
    {
        $this->setApiBaseUrl();
        $response = $this->sendRequestAndGetResponse($this->apiBaseUrl);
        $response = $response['response'][0];
        $response['email'] = $this->vkUserEmail;


        return $response;
    }

    private function setTokenUrl(): VkComponent
    {
        $this->tokenUrl = self::BASE_TOKEN_URL . $this->vkCode;
        return $this;
    }

    private function setApiBaseUrl(): VkComponent
    {
        if ($this->vkAccessToken && $this->vkUserId) {
            $this->apiBaseUrl = 'https://api.vk.com/method/users.get' .
                '?user_ids=' . $this->vkUserId .
                '&fields=home_town&access_token=' . $this->vkAccessToken .
                '&v=5.124';
        }
        return $this;
    }

    private function sendRequestAndGetResponse($url): array
    {
        $response = $this->client->request('GET', $url);
        $content = $response->getBody()->getContents();
        return $responseData = json_decode($content, true);
    }

    protected function initUserAttributes()
    {
        return $this->api('userinfo', 'GET');
    }

}
