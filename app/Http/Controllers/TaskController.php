<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{

    public function get()
    { 
        try {
            $tasks = Task::with('user', 'company')->get();
            
            $transformedTasks = $tasks->map(function ($task) {
                return [
                    'id' => $task->id,
                    'name' => $task->name,
                    'description' => $task->description,
                    'user' => $task->user->name,
                    'company' => [
                        'id' => $task->company->id,
                        'name' => $task->company->name,
                    ],
                ];
            });

            return response()->json($transformedTasks, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_id' => 'required',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'user_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $userTaskCount = Task::where('user_id', $request->input('user_id'))
            ->where('is_completed', 0)
            ->count();

        if ($userTaskCount >= 5) {
            return response()->json(['error' => 'Se ha alcanzado el límite de tareas pendientes por usuario.'], 400);
        }

        $task = Task::create($request->all());

        $task->load('user', 'company');

        $transformedTask = [
            'id' => $task->id,
            'name' => $task->name,
            'description' => $task->description,
            'user' => $task->user->name,
            'company' => [
                'id' => $task->company->id,
                'name' => $task->company->name,
            ],
        ];

        return response()->json(['message' => 'Tarea creada con éxito', 'task' => $transformedTask], 201);
    }
}
