<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait ExceptionTrait {

    public function apiException($request, $e)
    {
        if ($this->isModel($e)){
            return response()->json([
                'error' => 'product model not found'
            ], Response::HTTP_NOT_FOUND);
        }

        if ($this->isValidURL($e)){
            return response()->json([
                'error' => 'Invalid URL'
            ], Response::HTTP_NOT_FOUND);
        }
        return parent::render($request, $e);
    }

    private function isModel($e){
        return $e instanceof ModelNotFoundException;
    }

    private function isValidURL($e){
        return $e instanceof NotFoundHttpException;
    }


}
