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
        try {
            $tasks = TaskEntry::all();
            return new JsonResponse(
                [
                    'message' => 'success',
                    'tasks' => $tasks,
                    'status' => true
                ],
                Response::HTTP_OK
            );
        } catch (\Exception $ex) {
            Log::info('Exception thrown: ' . $ex->getMessage());
            return new JsonResponse(
                [
                    'message' => 'Unable to process request',
                    'status' => true
                ],
                Response::HTTP_OK
            );
        }
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
        try {
            $task = TaskEntry::findOrFail($id);

            if ($task->delete()) {
                return new JsonResponse(
                    [
                        'message' => 'Successfully deleted task',
                        'status' => true
                    ],
                    Response::HTTP_OK
                );
            } else {
                Log::info("Unable to delete task where id@$id");
                return new JsonResponse(
                    [
                        'message' => 'Could not delete task',
                        'status' => false
                    ],
                    Response::HTTP_OK
                );
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            Log::critical('Excpetion Thrown: ' . $ex->getMessage()); // Log exception for debugging purposes

            // Return JSON response indicating failure
            return new JsonResponse(
                [
                    'message' => 'Unable to process request',
                    'status' => false
                ],
                Response::HTTP_OK
            );
        }
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
    public function edit(Request $request, $id): JsonResponse
    {
        try {

            $validatedData = $request->validate([
                'task_title' => 'required|string|max:50',
                'task_description' => 'nullable|string',
                'task_completed' => 'boolean',
            ]);

            // Check if description is less than 255 characters
            if (strlen($validatedData['task_description']) > 255) {
                return new JsonResponse(
                    [
                        'message' => 'Description exceeded 255 characters',
                        'status' => false
                    ],
                    Response::HTTP_OK
                );
            }

            // Locate entry in database
            // Empty check not required -> Exception thrown
            $task = TaskEntry::findOrFail($id);

            // Update task attributes
            $task->task_title = $validatedData['task_title'];
            $task->task_description = $validatedData['task_description'];
            $task->task_completed = $request->has('task_completed') && $request->input('task_completed') == '1';

            if ($task->save()) {
                return new JsonResponse(
                    [
                        'message' => 'Task updated successfully',
                        'status' => true
                    ],
                    Response::HTTP_OK
                );
            } else {
                return new JsonResponse(
                    [
                        'message' => 'Unable to update task',
                        'status' => false
                    ],
                    Response::HTTP_OK
                );
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            Log::critical('Excpetion Thrown: ' . $ex->getMessage()); // Log exception for debugging purposes

            // Return JSON response indicating failure
            return new JsonResponse(
                [
                    'message' => 'Unable to process request',
                    'status' => false
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function token()
    {
        return csrf_token();
    }
}
