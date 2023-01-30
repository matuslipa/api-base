<?php

declare(strict_types=1);

namespace App\Core\Exceptions;

use App\Core\Parents\Exceptions\Exception;
use App\Core\Values\Enums\ResponseTypeEnum;
use App\Core\Values\Translation;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException as IlluminateValidationException;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

final class Handler extends ExceptionHandler
{
    /**
     * @inheritdoc
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
        \Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class,
        ValidationException::class,
    ];

    /**
     * @inheritdoc
     */
    protected $internalDontReport = [
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Illuminate\Auth\AuthenticationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Http\Exceptions\HttpResponseException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Symfony\Component\HttpFoundation\Exception\SuspiciousOperationException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * @var \Ramsey\Uuid\UuidInterface
     */
    protected UuidInterface $uuid;

    /**
     * Create a new exception handler instance.
     *
     * @param \Illuminate\Contracts\Container\Container $container
     * @param \Illuminate\Contracts\Foundation\Application $application
     */
    public function __construct(
        Container $container,
    ) {
        parent::__construct($container);

        $this->uuid = Str::uuid();
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $e
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function render($request, \Throwable $e): Response
    {
        $e = $this->prepareException($e);
        $e = $this->normalizeException($e);

        return $this->makeExceptionResponse($e);
    }

    /**
     * Normalize exception.
     *
     * @param \Throwable $exception
     * @return \App\Core\Parents\Exceptions\Exception
     */
    public function normalizeException(\Throwable $exception): Exception
    {
        switch (true) {
            case $exception instanceof Exception:
                return $exception;
            case $exception instanceof AuthenticationException:
            case $exception instanceof IlluminateValidationException:
                return $this->makeValidationException($exception);
            default:
                return $this->createGeneralException($exception);
        }
    }

    /**
     * Get the default context variables for logging.
     *
     * @return mixed[]
     */
    protected function context(): array
    {
        $data = [
            'uuid' => $this->uuid->toString(),
        ];

        try {
            /** @var \Illuminate\Auth\AuthManager $authManager */
            $authManager = $this->container->make(AuthManager::class);

            /** @var \Illuminate\Database\Eloquent\Model|null $user */
            $user = $authManager->guard()->user();

            return \array_merge(
                \array_filter([
                    'userId' => $user?->getKey(),
                    'email' => $user?->getAttribute('email'),
                ]),
                $data
            );
        } catch (\Throwable) {
            return $data;
        }
    }

    /**
     * Make a response object from the given validation exception.
     *
     * @param \Illuminate\Validation\ValidationException $e
     * @return \App\Core\Exceptions\ValidationException
     */
    protected function makeValidationException(IlluminateValidationException $e): ValidationException
    {
        $errors = [];

        foreach ($e->validator->errors()->getMessages() as $field => $error) {
            $params = [];

            if (\is_string($error) || $error instanceof Translation) {
                $message = $error;
            } else {
                $message = $error[0] ?? $error['message'];
                $params = $error[0]['params'] ?? [];
            }

            $errors[$field] = Translation::make(
                $message,
                \array_merge([
                    'attribute' => $field,
                ], $params)
            );
        }

        $exception = new ValidationException($e->getMessage(), $e, $e->getCode());
        $exception->setErrors($errors);
        return $exception;
    }

    /**
     * Create a response object from the given validation exception.
     *
     * @param \Throwable $exception
     * @return \App\Core\Parents\Exceptions\Exception
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function createGeneralException(\Throwable $exception): Exception
    {
        $normalizedException = new GeneralException(
            $exception->getMessage(),
            $exception,
            $exception->getCode()
        );

        if ($exception instanceof HttpExceptionInterface) {
            $normalizedException->setStatusCode($exception->getStatusCode());
        }

        $responseType = [
            403 => ResponseTypeEnum::UNAUTHORIZED(),
            404 => ResponseTypeEnum::NOT_FOUND(),
            405 => ResponseTypeEnum::METHOD_NOT_ALLOWED(),
            500 => ResponseTypeEnum::GENERAL(),
        ][$normalizedException->getStatusCode()] ?? ResponseTypeEnum::UNKNOWN();

        $normalizedException->setResponseType($responseType);

        // prevent outputting some sensitive data in production
        if ($normalizedException->getStatusCode() === 500 &&
            $this->container->make(Application::class)->environment('production')
        ) {
            $normalizedException->setMessage('exceptions.server_error');
        }

        return $normalizedException;
    }

    /**
     * Make response from exception.
     *
     * @param \App\Core\Parents\Exceptions\Exception $exception
     * @return \Illuminate\Http\JsonResponse
     */
    private function makeExceptionResponse(Exception $exception): JsonResponse
    {
        try {
            $translator = $this->container->make(Translator::class);
        } catch (BindingResolutionException) {
            $translator = null;
        }

        $data = [
            'type' => $exception->getResponseType()->getValue(),
            'message' => $exception->getMessage(),
            'id' => $this->uuid->toString(),
        ];

        if ($exception->hasErrors()) {
            $data['errors'] = [];

            foreach ($exception->getErrors() as $field => $message) {
                $message = $message instanceof Translation
                    ? $message->toString($translator)
                    : $translator->get($message);

                $data['errors'][] = [
                    'field' => $field,
                    'message' => $message,
                ];
            }
        }

        return new JsonResponse($data, $exception->getStatusCode(), $exception->getResponseHeaders());
    }
}
