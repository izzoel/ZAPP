<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KeycloakService
{
    protected string $baseUrl;
    protected string $realm;

    public function __construct()
    {
        $this->baseUrl = config('services.keycloak.base_url');
        $this->realm = config('services.keycloak.realms');
    }

    protected function getAdminToken(): ?string
    {
        $response = Http::asForm()->post("{$this->baseUrl}/realms/{$this->realm}/protocol/openid-connect/token", [
            'client_id' => 'admin-cli',
            'grant_type' => 'password',
            'username' => env('KEYCLOAK_ADMIN_USER'),
            'password' => env('KEYCLOAK_ADMIN_PASS'),
        ]);

        return $response->json('access_token');
    }

    public function updateUser(string $keycloakId, array $data): bool
    {
        $token = $this->getAdminToken();
        if (!$token) {
            return false;
        }
        return Http::withToken($token)
            ->put("{$this->baseUrl}/admin/realms/{$this->realm}/users/{$keycloakId}", $data)
            ->successful();
    }
}
