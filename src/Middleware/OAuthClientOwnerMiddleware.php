<?php

/*
 * This file is part of OAuth 2.0 Laravel.
 *
 * (c) Luca Degasperi <packages@lucadegasperi.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nexusvc\OAuth2Server\Middleware;

use Closure;
use Nexusvc\OAuth2\Server\Exception\AccessDeniedException;
use Nexusvc\OAuth2Server\Authorizer;

/**
 * This is the oauth client middleware class.
 *
 * @author Vincent Klaiber <hello@vinkla.com>
 */
class OAuthClientOwnerMiddleware
{
    /**
     * The Authorizer instance.
     *
     * @var \Nexusvc\OAuth2Server\Authorizer
     */
    protected $authorizer;

    /**
     * Create a new oauth client middleware instance.
     *
     * @param \Nexusvc\OAuth2Server\Authorizer $authorizer
     */
    public function __construct(Authorizer $authorizer)
    {
        $this->authorizer = $authorizer;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @throws \League\OAuth2\Server\Exception\AccessDeniedException
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->authorizer->setRequest($request);

        if ($this->authorizer->getResourceOwnerType() !== 'client') {
            throw new AccessDeniedException();
        }

        return $next($request);
    }
}
