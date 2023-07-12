<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->wantsJson()) {

                $model = $this->extractModelNameFromException($e->getMessage());

                $translatedModel = Lang::get("models.$model");

                return response()->json([
                    'message' => $translatedModel . ' مورد نظر یافت نشد',
                ]);
            }
        });
    }

    private function extractModelNameFromException(string $exceptionMessage): string
    {
        $matches = [];
        preg_match('/No query results for model \[(.*?)\]/', $exceptionMessage, $matches);

        return $matches[1] ?? 'Unknown Model';
    }
}
