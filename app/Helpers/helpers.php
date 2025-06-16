<?php


use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;

if (!function_exists('paginationIndex')) {
    function paginationIndex($loopIndex, $paginator): float|int
    {
        return ($paginator->currentPage() - 1) * $paginator->perPage() + $loopIndex + 1;
    }
}

function findModelOrFail($modelClass, $id, $notFoundMessage = null)
{
    try {
        return $modelClass::findOrFail($id);
    } catch (ModelNotFoundException $e) {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => $notFoundMessage ?? class_basename($modelClass) . " not found with id: $id"
        ], 404));
    }
}
