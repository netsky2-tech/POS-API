<?php

namespace Tests\Helpers;

use Illuminate\Testing\TestResponse;

trait HandlesAuthCookies
{
    /**
     * Realiza el login y retorna las cookies necesarias.
     */
    public function loginAndGetCookies(array $credentials): array
    {
        $response = $this->json('POST', '/api/auth/login', $credentials);

        return $response->headers->getCookies();
    }

    /**
     * Extrae las cookies de una respuesta.
     */
    private function extractCookies(TestResponse $response): array
    {
        $cookies = $response->headers->getCookies();

        return collect($cookies)->mapWithKeys(function ($cookie) {
            return [$cookie->getName() => $cookie->getValue()];
        })->toArray();
    }

    /**
     * Agrega las cookies necesarias a la siguiente solicitud.
     */
    public function withAuthCookies(array $cookies): \Tests\Feature\AuthApiTest
    {
        foreach ($cookies as $cookie) {
            $this->withCookie($cookie->getName(), $cookie->getValue());
        }
        return $this;
    }

    /**
     * Realiza un login y devuelve una instancia con cookies preconfiguradas.
     */
    public function loginAsUser(array $credentials)
    {
        $cookies = $this->loginAndGetCookies($credentials);

        return $this->withAuthCookies($cookies);
    }
}
