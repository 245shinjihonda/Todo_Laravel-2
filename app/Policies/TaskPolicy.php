<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Task;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

// 指定されたユーザーのみ自己のタスクを削除可能
// destroy関数の設定
// @param User $user
// @param Task $task
// @return bool
public function destroy(User $user, Task $task)
{
    return $user->id === $task->user_id;
}

}