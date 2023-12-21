<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    public function get()
    {
        $companies = Company::with('tasks')->get();

        $formattedCompanies = $companies->map(function ($company) {
            return [
                'id' => $company->id,
                'name' => $company->name,
                'tasks' => $company->tasks->map(function ($task) {
                    return [
                        'id' => $task->id,
                        'name' => $task->name,
                        'description' => $task->description,
                        'user' => $task->user->name,
                        'is_completed' => $task->is_completed,
                        'start_at' => $task->start_at,
                        'expired_at' => $task->expired_at,
                    ];
                }),
            ];
        });

        return response()->json($formattedCompanies);
    }
}
