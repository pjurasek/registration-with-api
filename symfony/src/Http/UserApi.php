<?php

namespace App\Http;

use App\Entity\User;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class UserApi
{
    /** @var HttpClientInterface  */
    private $client;

    /**
     * @param HttpClientInterface $client
     */
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }


    /**
     * @param User $user
     * @return array
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function storeInformation(User $user): array
    {
        $response = $this->client->request(
            'POST',
            'http://service-nginx:80/api/users',
            [
                'headers' => [
                    'Accept' => 'application/json'
                ],
                'json' => [
                    'username' => $user->getUsername(),
                    'email' => $user->getEmail(),
                    'roles' => $user->getRoles(),
                    'password' => $user->getPassword(),
                ],
            ]
        );

        $statusCode = $response->getStatusCode();
        if (201 !== $statusCode) {
            $responseContent = $response->getContent();

            throw new \Exception('Failed to create an entity: '
                . $statusCode . $responseContent);
        }

        return $response->toArray();
    }

    /**
     * @return array
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function fetchInformation(): array
    {
        $response = $this->client->request(
            'GET',
            'http://service-nginx:80/api/users',
            [
                'headers' => [
                    'Accept' => 'application/json'
                ],
                'query' => [
                    'page' => 1,
                ]
            ]
        );

        $statusCode = $response->getStatusCode();
        if (200 !== $statusCode) {
            $responseContent = $response->getContent();

            throw new \Exception('Failed to create a request: '
                . $statusCode . $responseContent);
        }

        return $response->toArray();
    }

}