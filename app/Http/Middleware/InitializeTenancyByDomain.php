<?php

// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Http\Request;
// use Stancl\Tenancy\Resolvers\DomainTenantResolver;
// use Stancl\Tenancy\Tenancy;

// class InitializeTenancyByDomain
// {
//     protected $tenancy;
//     protected $resolver;

//     public function __construct(Tenancy $tenancy, DomainTenantResolver $resolver)
//     {
//         $this->tenancy = $tenancy;
//         $this->resolver = $resolver;
//     }

//     public function handle(Request $request, Closure $next)
//     {
//         try {
//             $tenant = $this->resolver->resolve($request);
            
//             if ($tenant) {
//                 $this->tenancy->initialize($tenant);
//             }
//         } catch (\Exception $e) {
//             // Handle exception (e.g., tenant not found)
//             return response()->json(['error' => 'Tenant not found'], 404);
//         }

//         return $next($request);
//     }
// }