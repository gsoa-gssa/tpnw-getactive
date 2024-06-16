<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetAppLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $domain = $request->getHost();
        switch ($domain) {
            case 'go.atomwaffenverbot.ch':
                app()->setLocale('de');
                break;
            case 'go.interdiction-armes-nucleaires.ch':
                app()->setLocale('fr');
                break;
            case 'go.interdizione-armi-nucleari.ch':
                app()->setLocale('it');
                break;
            default:
                app()->setLocale('de');
                break;
        }
        return $next($request);
    }
}
