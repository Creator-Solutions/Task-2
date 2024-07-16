<?php

namespace App\Http\Controllers;

use App\Models\TaskEntry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function index(): JsonResponse
    {

    }

    /**
     * -----------------
     * Create Endpoint
     * -----------------
     *
     * Method called from the
     * /create endpoint to create
     * a new task entry
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            // Validate incoming request
            $validatedData = $request->validate([
                'task_title' => 'required|string|max:50',
                'task_description' => 'nullable|string',
                'task_completed' => 'boolean',
            ]);

            // Check if description content exceeds 255 characters
            if (strlen($validatedData['task_description']) > 255) {
                return new JsonResponse(
                    [
                        'message' => 'Description length exceeded',
                        'status' => false
                    ],
                    Response::HTTP_OK
                );
            }

            // Check if record matches the task title provided
            if (TaskEntry::where('task_title', $validatedData['task_title'])->exists()) {
                return new JsonResponse(
                    [
                        'message' => 'Task already exists',
                        'status' => false
                    ],
                    Response::HTTP_OK
                );
            }

            // Create Task entry in the task table
            // Returns an array with the record information
            $task = TaskEntry::create([
                'task_title' => $validatedData['task_title'],
                'task_description' => $validatedData['task_description'],
                'task_completed' => $request->has('task_completed') ? true : false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            //Check if task was created successfully
            if ($task) {
                return new JsonResponse(
                    [
                        'message' => 'Task created successfully',
                        'status' => true
                    ],
                    Response::HTTP_OK
                );
            } else {
                return new JsonResponse(
                    [
                        'message' => 'Could not create task',
                        'status' => false
                    ],
                    Response::HTTP_OK
                );
            }
        } catch (\Exception $ex) {
            Log::info('Exception thrown' . $ex->getMessage()); // Log exception for debugging purposes

            // return JSON response
            return new JsonResponse(
                [
                    'message' => 'Unable to process request',
                    'status' => false
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * ---------------------
     * Delete Endpoint
     * ----------------------
     *
     * Method called from the
     * DELETE::tasks/ endpoint
     * to delete a task record based
     * on ID
     *
     * @param [type] $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {

    }

    /**
     * -----------------
     * Edit Endpoint
     * -----------------
     *
     * Edit endpoint called from
     * the PUT::tasks/ endpoint
     * to update/edit any records
     * based on record id
     *
     * @param [type] $id
     * @return JsonResponse
     */
    public function edit($id): JsonResponse
    {
        return new JsonResponse(['message' => 'Main Edit of records', 'status' => true], 200);
    }

    public function token()
    {
        return csrf_token();
    }
}
