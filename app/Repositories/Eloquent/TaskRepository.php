<?php

namespace App\Repositories\Eloquent;

use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TaskRepository implements TaskRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function paginate(int $perPage = 10, ?int $page = null): LengthAwarePaginator
    {
        return Task::paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * @inheritDoc
     */
    public function store(array $data): Task
    {
        return Task::create($data);
    }
}
