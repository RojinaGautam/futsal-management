<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Stancl\Tenancy\Exceptions\TenantCouldNotBeIdentifiedOnDomainException;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Resolvers\DomainTenantResolver;

class CheckTenantOrShowMessage
{
    protected $resolver;

    public function __construct(DomainTenantResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    public function handle(Request $request, Closure $next): Response
    {
        // Skip this middleware if we're on the central domain
        if ($request->getHost() !== config('tenancy.central_domains')[0]) {
            // Attempt to identify tenant
            $tenant = $this->resolver->resolve($request->getHost());
            
            // If no tenant was identified, return 404
            if (!$tenant) {
                abort(404, 'Tenant not found');
            }
        }

        return $next($request);
    }
}