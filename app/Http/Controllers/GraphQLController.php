<?php

namespace App\Http\Controllers;

use App\Exceptions\ApplicationException;
use App\GraphQL\SchemaFactory;
use Exception;
use GraphQL\Error\Error;
use GraphQL\GraphQL;
use Illuminate\Http\Request;

class GraphQLController extends Controller
{
    /**
     * @param $access
     * @param SchemaFactory $schemaFactory
     * @param Request $request
     * @param GraphQL $graphQL
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Exception
     */
    public function index($access, SchemaFactory $schemaFactory, Request $request, GraphQL $graphQL)
    {
        $query = $request->get('query');
        $variables = $request->get('variables');

        /*
         * Check operations
         */
        if (is_null($query) && is_null($variables) && $request->has('operations')) {
            $operations = json_decode($request->get('operations'), true);
            $query = $operations['query'];
            $variables = $operations['variables'];
        }

        /*
         * Check module
         */
        if (!in_array($access, ['test-panel',])) {
            dd($access);
            abort(404);
        }

        /*
         * Show GraphiQL
         */
        if (is_null($query)) {
            if (env('APP_ENV') == 'production') {
                abort(404);
            }

            return view('graphql.' . $access);
        }

        $defaultErrorFormatter = function (Error $error) {
            $newError = [];
            $previous = $error->getPrevious();
            unset($previous->xdebug_message);
            $originalException = null;

            if ($previous) {
                if (!isset($previous->originalExceptionData) && $previous instanceof Exception) {
                    $originalException = $previous;
                } elseif (isset($previous->originalExceptionData)) {
                    $originalException = new ApplicationException(json_encode($previous->originalExceptionData));
                }

                foreach ($previous as $key => $value) {
                    $newError[$key] = $value;
                }

                $newError['originalExceptionData'] = $originalException;
                $newError['code'] = $previous->getCode();
            }

            $newError['message'] = $error->getMessage();

            if (!isset($newError['code'])) {
                $newError['code'] = $error->getCode();
            }

            return $newError;
        };

        $defaultErrorHandler = function (array $errors, callable $formatter) {
            return array_map($formatter, $errors);
        };

        /*
         * Execute Query
         */
        $result = $graphQL->executeQuery($schemaFactory->create($access), $query, null, null, $variables)
            ->setErrorFormatter($defaultErrorFormatter)
            ->setErrorsHandler($defaultErrorHandler)
            ->toArray();

        /*
         * Show error
         */
        $errors = $result['errors'] ?? [];
        if (count($errors) > 0) {
            $originalExceptionData = data_get($errors, '0.originalExceptionData');

            if (!is_null($originalExceptionData)) {
                report($originalExceptionData);
            }

            $errors = collect($errors)->map(function ($error) {
                unset($error['originalExceptionData']);
                return $error;
            });

            return response()->json(['errors' => $errors]);
        }

        /*
         * Response
         */
        return response()->json($result);
    }
}
