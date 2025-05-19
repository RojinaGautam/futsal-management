<?php

// namespace App\Services\Tenancy;

// use Stancl\Tenancy\Resolvers\DomainTenantResolver as BaseDomainTenantResolver;

// class CustomDomainTenantResolver extends BaseDomainTenantResolver
// {
//     public function resolve($domain): ?object
//     {
//         // First try the normal resolution process
//         $tenant = parent::resolve($domain);
        
//         if (!$tenant) {
//             // Log the attempt with the unidentified domain
//             // logger()->warning('Unidentified tenant domain: ' . $domain);
//         }
        
//         return $tenant;
//     }
// }