<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->render(function (AuthenticationException $e, Request $request) {
            return $request->is('api/*')
                ? response()->json(['status' => false, 'message' => 'Unauthorized access. Please log in.'], 401)
                : redirect()->route('login')->with('error', 'Unauthorized access. Please log in.');
        });


        $exceptions->render(function (AccessDeniedHttpException $e, Request $request) {
            return $request->is('api/*')
                ? response()->json(['status' => false, 'message' => 'You do not have permission to perform this action.'], 403)
                : back()->with('error', 'You do not have permission to perform this action.');
        });

        $exceptions->render(function (NotFoundHttpException|ModelNotFoundException $e, Request $request) {
            return $request->is('api/*')
                ? response()->json(['status' => false, 'message' => 'Resource not found.'], 404)
                : abort(404, 'Resource not found.');
        });

        // Method Not Allowed
        $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) {
            return $request->is('api/*')
                ? response()->json(['status' => false, 'message' => 'HTTP method not allowed for this route.'], 405)
                : abort(405, 'HTTP method not allowed.');
        });

        // Route Not Found
        $exceptions->render(function (RouteNotFoundException $e, Request $request) {
            return $request->is('api/*')
                ? response()->json(['status' => false, 'message' => 'Route not found.'], 404)
                : abort(404, 'Route not found.');
        });
    })->create();
