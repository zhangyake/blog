<?php

namespace App\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiController extends Controller
{
    /**
     * Respond with a created response and associate a location if provided.
     *
     * @param string|null $location
     * @param null        $content
     *
     * @return Response
     */
    public function created($location = null, $content = null)
    {
        $response = new Response($content);
        // 201
        $response->setStatusCode(Response::HTTP_CREATED);
        if (!is_null($location)) {
            $response->header('Location', $location);
        }

        return $response;
    }

    /**
     * Respond with an accepted response and associate a location and/or content if provided.
     *
     * @param string|null $location
     * @param mixed       $content
     *
     * @return Response
     */
    public function accepted($location = null, $content = null)
    {
        $response = new Response($content);
        // 202
        $response->setStatusCode(Response::HTTP_ACCEPTED);
        if (!is_null($location)) {
            $response->header('Location', $location);
        }

        return $response;
    }

    /**
     * Respond with a no content response.
     *
     * @return Response
     */
    public function noContent()
    {
        $response = new Response(null);
        // 204
        return $response->setStatusCode(Response::HTTP_NO_CONTENT);
    }

    /**
     * Return a json response.
     *
     * @param array $data
     * @param array $headers
     *
     * @return Response
     */
    public function json($data = [], array $headers = [])
    {
        return new Response(compact('data'), Response::HTTP_OK, $headers);
    }

    /**
     *  Bind an item to a apiResource and start building a response.
     *
     * @param JsonResource $resource
     * @param array        $meta
     *
     * @return mixed
     */
    public function item(JsonResource $resource, $meta = [])
    {
        if (is_null($resource)) {
            return compact('data');
        }
        if (count($meta)) {
            return $resource->additional($meta);
        }

        return $resource;
    }

    /**
     * Bind a collection to a apiResource and start building a response.
     *
     * @param ResourceCollection $collection
     * @param array              $meta
     *
     * @return ResourceCollection|Response
     */
    public function collection(ResourceCollection $collection, $meta = [])
    {
        if (count($meta)) {
            return $collection->additional($meta);
        }

        return $collection;
    }

    /**
     * Return an error response.
     *
     * @param string $message
     * @param        $statusCode
     */
    public function error($message, $statusCode = 400)
    {
        // return new Response(compact('message','status_code'),$status_code,$header);
        throw new HttpException($statusCode, $message);
    }

    /**
     * Return a 404 not found error.
     *
     * @param string $message
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function errorNotFound($message = 'Not Found')
    {
        // 404
        $this->error($message, Response::HTTP_NOT_FOUND);
    }

    /**
     * Return a 400 bad request error.
     *
     * @param string $message
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function errorBadRequest($message = 'Bad Request')
    {
        // 400
        $this->error($message, Response::HTTP_BAD_REQUEST);
    }

    /**
     * Return a 403 forbidden error.
     *
     * @param string $message
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function errorForbidden($message = 'Forbidden')
    {
        // 403
        $this->error($message, Response::HTTP_FORBIDDEN);
    }

    /**
     * Return a 500 internal server error.
     *
     * @param string $message
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function errorInternal($message = 'Internal Error')
    {
        // 500
        $this->error($message, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Return a 401 unauthorized error.
     *
     * @param string $message
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function errorUnauthorized($message = 'Unauthorized')
    {
        // 401
        $this->error($message, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Return a 405 method not allowed error.
     *
     * @param string $message
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function errorMethodNotAllowed($message = 'Method Not Allowed')
    {
        // 405
        $this->error($message, Response::HTTP_METHOD_NOT_ALLOWED);
    }
}
