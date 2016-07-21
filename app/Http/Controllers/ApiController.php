<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Http\Response;

class ApiController extends Controller
{
    public function respondOk(array $data){
        return $this->respond($data, Response::HTTP_OK);
    }

    public function respondNotFound(array $data){
        return $this->respond($data, Response::HTTP_NOT_FOUND);
    }

    public function respondUnprocessableEntity(array $data) {
        return $this->respond($data, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function respondCreated(array $data) {
        return $this->respond($data, Response::HTTP_CREATED);
    }

    public function respondUnauthorized(array $data) {
        return $this->respond($data, Response::HTTP_UNAUTHORIZED);
    }

    public function respondNotAcceptable(array $data) {
        return $this->respond($data, Response::HTTP_NOT_ACCEPTABLE);
    }
    public function respond(array $data, $status, array $headers = array()) {
        return $this->rawRespond($data, [], $status, $headers);
    }

    public function rawRespond(array $data, array $meta, $status, array $headers = array()) {
        return $this->getResponseFactory()->json(array_merge($meta, [
            'data' => $data,
            'status' => $status,
        ]), $status, $headers);

    }
    protected function getResponseFactory() {
        return app('Illuminate\Routing\ResponseFactory');
    }

    protected function buildFailedValidationResponse(Request $request, array $errors) {
        return $this->respondUnprocessableEntity($errors);
    }

    protected function buildGeneralErrorResponse($message) {
        return [
            'general' => [$message]
        ];
    }
}
