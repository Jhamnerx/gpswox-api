<?php

namespace Gpswox\Resources;

use Gpswox\Wox;

class Task
{
    protected $client;

    public function __construct(Wox $client)
    {
        $this->client = $client;
    }

    /**
     * Get tasks
     * Retrieves all tasks.
     * 
     * @param array $filters Optional filters
     * @return array List of tasks
     */
    public function getTasks(array $filters = [])
    {
        return $this->client->request('GET', 'api/get_tasks', ['query' => $filters]);
    }

    /**
     * Get task
     * Retrieves a specific task by ID.
     * 
     * @param int $taskId Task ID
     * @param array $params Optional parameters
     * @return array Task details
     */
    public function getTask(int $taskId, array $params = [])
    {
        return $this->client->request('GET', "api/get_task/{$taskId}", ['query' => $params]);
    }

    /**
     * Create task
     * Creates a new task.
     * 
     * @param array $data Task data
     * @return array Created task response
     */
    public function addTask(array $data)
    {
        return $this->client->request('POST', 'api/add_task', ['json' => $data]);
    }

    /**
     * Edit task
     * Updates an existing task.
     * 
     * @param int $taskId Task ID
     * @param array $data Task data to update
     * @return array Updated task response
     */
    public function editTask(int $taskId, array $data)
    {
        return $this->client->request('POST', "api/edit_task/{$taskId}", ['json' => $data]);
    }

    /**
     * Delete task
     * Deletes a task.
     * 
     * @param int $taskId Task ID
     * @return array Deletion response
     */
    public function destroyTask(int $taskId)
    {
        return $this->client->request('POST', 'api/destroy_task', ['json' => ['task_id' => $taskId]]);
    }

    /**
     * Get task signature
     * Retrieves the signature for a task status.
     * 
     * @param int $taskStatusId Task status ID
     * @param array $params Optional parameters
     * @return array Task signature
     */
    public function getTaskSignature(int $taskStatusId, array $params = [])
    {
        return $this->client->request('GET', "api/get_task_signature/{$taskStatusId}", ['query' => $params]);
    }

    /**
     * Get task statuses
     * Retrieves available task statuses.
     * 
     * @param array $params Optional parameters
     * @return array Task statuses
     */
    public function getTaskStatuses(array $params = [])
    {
        return $this->client->request('GET', 'api/get_tasks_statuses', ['query' => $params]);
    }

    /**
     * Get task priorities
     * Retrieves available task priorities.
     * 
     * @param array $params Optional parameters
     * @return array Task priorities
     */
    public function getTaskPriorities(array $params = [])
    {
        return $this->client->request('GET', 'api/get_tasks_priorities', ['query' => $params]);
    }
}
