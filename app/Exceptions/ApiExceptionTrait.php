<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

trait ApiExceptionTrait {

    public function apiException($request, $e) {

        if($this->notModel($e)) {
            return $this->notModelMessage($e);
        }

        if($this->notHttp($e)) {
            return $this->notHttpMessage();
        }

        if($this->notAuthorized($e)) {
            return $this->notAuthorizedMessage($e);
        }

        if($this->notMethod($e)) {
            return $this->notMethodMessage();
        }

        return parent::render($request, $e);
    }

    private function notModel($e) {
        return $e instanceof ModelNotFoundException;
    }

    private function notHttp($e) {
        return $e instanceof NotFoundHttpException;
    }

    private function notAuthorized($e) {
        return $e instanceof UnauthorizedHttpException;
    }

    private function notMethod($e) {
        return $e instanceof MethodNotAllowedHttpException;
    }

    public function notModelMessage($e)
    {
        return response()->json(['success' => false, 'message' => 'Entry for '.str_replace('App\\', '', $e->getModel()).' not found'], Response::HTTP_NOT_FOUND);
    }

    public function notHttpMessage()
    {
        return response()->json(['success' => false, 'message' => 'Invalid route'], Response::HTTP_NOT_FOUND);
    }

    public function notMethodMessage()
    {
        return response()->json(['success' => false, 'message' => 'Bad request method'], Response::HTTP_BAD_REQUEST);
    }

    public function notAuthorizedMessage($e)
    {
        $getException = $e->getPrevious();
        
        if($getException instanceof TokenInvalidException) {
            return response()->json(['success' => false, 'message' => 'Invalid token'], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json(['success' => false, 'message' => 'You are not authorized'], Response::HTTP_UNAUTHORIZED);
    }
}