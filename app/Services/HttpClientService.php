<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\Services\HttpClientException;
use GuzzleHttp\Exception\GuzzleException;
use stdClass;
use GuzzleHttp\Client;
use SimpleXMLElement;
use App;
use Config;

class HttpClientService
{
    protected const HTTP_TIMEOUT = 10;

    public function getJson(string $url, array $auth = []) : stdClass
    {
        $response = $this->get($url, $auth);

        // to json
        $json = json_decode($response);
        if (json_error($json)) {
            throw new HttpClientException('Invalid json: ' . $response);
        }

        return $json;
    }

    public function getXml(string $url, array $auth = []) : SimpleXMLElement
    {
        $response = $this->get($url, $auth);

        // to xml
        try {
            return new SimpleXMLElement($response);
        } catch (Exception $e) {
            throw new HttpClientException('Invalid xml: ' . $response);
        }
    }

    protected function get(string $url, array $auth = []) : string
    {
        try {
            $client  = new Client();

            $options = [
                'timeout' => self::HTTP_TIMEOUT,
                'auth'    => $auth,
            ];

            // al correr los test, no verificar el vertificado ssl
            if (App::runningUnitTests()
                && preg_match('/^https\:\/\/' . preg_quote(Config::get('app.domains.web'), '/') . '/', $url)) {
                $options['verify'] = false;
            }

            $request = $client->request('GET', $url, $options);

            // check http status code
            $requestStatusCode = $request->getStatusCode();
            if ($requestStatusCode !== 200) {
                throw new HttpClientException('Invalid status code: ' . $requestStatusCode);
            }

            return $request->getBody()->getContents();
        } catch (GuzzleException $e) {
            throw new HttpClientException('GuzzleException: ' . $e->getMessage());
        }
    }
}
