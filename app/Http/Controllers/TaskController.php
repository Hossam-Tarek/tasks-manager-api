<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * @var TaskRepositoryInterface
     */
    protected TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $page = $request->get('page', 1);

        $tasks = $this->taskRepository->paginate($perPage, $page);

        return ApiHelper::success([
            'tasks' => TaskResource::collection($tasks),
            'per_page' => $tasks->perPage(),
            'total' => $tasks->total(),
            'current_page' => $tasks->currentPage(),
        ], 'Tasks retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        $task = $this->taskRepository->store($request->validated());

        return ApiHelper::success($task, 'Task created successfully.', 201);
    }
}
