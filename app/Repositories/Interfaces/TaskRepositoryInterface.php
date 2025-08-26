<?php

namespace App\Repositories\Interfaces;

use App\Models\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TaskRepositoryInterface
{
    /**
     * Paginate tasks.
     *
     * @param int $perPage
     * @param int|null $page
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 10, ?int $page = null): LengthAwarePaginator;

    /**
     * Store a new task.
     *
     * @param array $data Task attributes.
     * @return Task Newly created task.
     */
    public function store(array $data): Task;
}
