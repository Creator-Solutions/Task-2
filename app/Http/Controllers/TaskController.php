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
        return new JsonResponse(['message' => 'Main fetching of records', 'status' => true], 200);
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

            $validatedData = $request->validate([
                'tasktitle' => 'required|string|max:50',
                'taskdescription' => 'nullable|string',
                'taskcompleted' => 'boolean',
            ]);

            // Check if description content exceeds 255 characters
            if (strlen($validatedData['taskdescription']) > 255) {
                return new JsonResponse(
                    [
                        'message' => 'Description length exceeded',
                        'status' => false
                    ],
                    Response::HTTP_OK
                );
            }

            // Check if record matches the task title provided
            if (TaskEntry::where('task_title', $validatedData['tasktitle'])->exists()) {
                return new JsonResponse(
                    [
                        'message' => 'Task already exists',
                        'status' => false
                    ],
                    Response::HTTP_OK
                );
            }

            $task = TaskEntry::create([
                'task_title' => $validatedData['tasktitle'],
                'task_description' => $validatedData['taskdescription'],
                'task_completed' => $request->has('taskcompleted') ? true : false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            //Check if task was created successfully
            if ($task) {
                return new JsonResponse(
                    [
                        'message' => 'Task created successfully',
                        'status' => false
                    ],
                    Response::HTTP_OK
                );
            } else {
                return new JsonResponse(
                    [
                        'message' => 'Task created successfully',
                        'status' => false
                    ],
                    Response::HTTP_OK
                );
            }
        } catch (\Exception $ex) {
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
        return new JsonResponse(['message' => 'Main Deletion of records', 'status' => true], 200);
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
