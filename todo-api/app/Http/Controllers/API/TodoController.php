<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Contracts\TodoRepositoryInterface;
use App\Enums\StatusCodeEnum;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class TodoController extends Controller
{
    public function __construct(
        protected TodoRepositoryInterface $todoRepository
    ) {
    }

    public function index(): JsonResponse
    {
        $todos = $this->todoRepository->getAll();

        return $this->sendResponse(
            'success',
            StatusCodeEnum::SUCCESS,
            'Todos retrieved successfully.',
            $todos
        );
    }

    public function store(Request $request): JsonResponse
    {
        $validation = $this->validateRequest($request, [
            'description' => 'required',
        ]);

        if (!$validation->validated) {
            return $this->sendResponse(
                'error',
                StatusCodeEnum::UNPROCESSABLE_ENTITY,
                $validation->message,
            );
        }

        $todo = $this->todoRepository->create($validation->data);

        return $this->sendResponse(
            'success',
            StatusCodeEnum::SUCCESS,
            'Todo created successfully.',
        );
    }

    public function update(Request $request, $id): JsonResponse
    {
        $validation = $this->validateRequest($request, [
            'description' => 'required',
        ]);

        if (!$validation->validated) {
            return $this->sendResponse(
                'error',
                StatusCodeEnum::UNPROCESSABLE_ENTITY,
                $validation->message,
            );
        }

        $todo = $this->todoRepository->update($id, $validation->data);

        if (!$todo) {
            return $this->sendResponse(
                'error',
                StatusCodeEnum::NOT_FOUND,
                'There was an error during update',
            );
        }

        return $this->sendResponse(
            'success',
            StatusCodeEnum::SUCCESS,
            'Todo updated successfully.',
        );
    }

    public function deleteItem($id): JsonResponse
    {
        $todo = $this->todoRepository->delete($id);

        if (!$todo) {
            return $this->sendResponse(
                'error',
                StatusCodeEnum::NOT_FOUND,
                'There was an error during delete'
            );
        }

        return $this->sendResponse(
            'success',
            StatusCodeEnum::SUCCESS,
            'Todo deleted successfully.'
        );
    }
}
