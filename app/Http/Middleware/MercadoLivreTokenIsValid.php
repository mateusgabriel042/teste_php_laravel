<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cache;
use App\Services\MercadoLivreService;


class MercadoLivreTokenIsValid
{
    private $mercadoLivreService;

    public function __construct(MercadoLivreService $mercadoLivreService)
    {
        $this->mercadoLivreService = $mercadoLivreService;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = Cache::get('mercado_livre_token');
        if (!$token) {
            $token = $this->mercadoLivreService->refreshToken()['access_token'];
            Cache::put('mercado_livre_token', $token, 60);
        }
        $expiresAt = Cache::get('mercado_livre_token_expires_at');
        $currentTime = time();
        if (!$expiresAt || $expiresAt < $currentTime) {
            $token = $this->mercadoLivreService->refreshToken()['access_token'];
            $expiresAt = $currentTime + 60;
            Cache::put('mercado_livre_token', $token, $expiresAt);
            Cache::put('mercado_livre_token_expires_at', $expiresAt, $expiresAt);
        }
        return $next($request);
    }
}
