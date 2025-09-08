<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

//use Throwable;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->use([
            \Illuminate\Foundation\Http\Middleware\InvokeDeferredCallbacks::class,
            \Illuminate\Http\Middleware\TrustProxies::class,
            \Illuminate\Http\Middleware\HandleCors::class,
            \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
            \Illuminate\Http\Middleware\ValidatePostSize::class,
            \Illuminate\Foundation\Http\Middleware\TrimStrings::class,
            \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        ]);

        $middleware->alias([
            'jwt' => \App\Http\Middleware\JwtMiddleware::class,
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (Throwable $e, $request) {

            return match (true) {
                $e instanceof ValidationException => response()->json([
                    'message' => 'The given data was invalid.',
                    'errors'  => $e->errors(),
                ], 422),

                $e instanceof AuthenticationException => response()->json([
                    'message' => 'Unauthenticated.',
                ], 401),

                $e instanceof AuthorizationException => response()->json([
                    'message' => $e->getMessage() ?: 'Forbidden.',
                ], 403),

                $e instanceof ModelNotFoundException => response()->json([
                    'message' => str_replace('App\\Models\\', '', $e->getModel()) . ' not found.',
                ], 404),

                $e instanceof ThrottleRequestsException => response()->json([
                    'message'      => 'Too many attempts. Slow down.',
                    'retry_after'  => $e->getHeaders()['Retry-After'] ?? null,
                ], 429),

                $e instanceof HttpExceptionInterface => response()->json([
                    'message' => $e->getMessage()
                        ?: \Symfony\Component\HttpFoundation\Response::$statusTexts[$e->getStatusCode()],
                ], $e->getStatusCode()),

                default => response()->json([
                    'message' => config('app.debug')
                        ? $e->getMessage()
                        : 'Server error.',
                ], 500),
            };
        });
    })->create();
