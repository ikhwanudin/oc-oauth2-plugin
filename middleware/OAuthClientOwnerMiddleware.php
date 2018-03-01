<?php namespace Octobro\OAuth2\Middleware;

use Closure;
use League\OAuth2\Server\Exception\AccessDeniedException;
use Octobro\OAuth2\Classes\Authorizer;

/**
 * This is the oauth client middleware class.
 */
class OAuthClientOwnerMiddleware
{
    /**
     * The Authorizer instance.
     *
     * @var \Octobro\OAuth2\Classes\Authorizer
     */
    protected $authorizer;

    /**
     * Create a new oauth client middleware instance.
     *
     * @param \Octobro\OAuth2\Classes\Authorizer $authorizer
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
