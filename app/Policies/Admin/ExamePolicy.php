<?php

namespace App\Policies\Admin;

use App\Models\Exame;
use App\Models\User;
use App\Traits\PolicyPermission;
use Illuminate\Auth\Access\HandlesAuthorization;


class ExamePolicy
{
    use HandlesAuthorization;
    use PolicyPermission;

    public function before(User $user, $ability)
    {
        if($user->isAdmin($user))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Exame  $exame
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Exame $exame)
    {
        return PolicyPermission::permission($user, '3', 'exclui');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return PolicyPermission::permission($user, '3', 'inclui');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Exame  $exame
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Exame $exame)
    {
        return PolicyPermission::permission($user, '3', 'altera');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Exame  $exame
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Exame $exame)
    {
        return PolicyPermission::permission($user, '3', 'exclui');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Exame  $exame
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Exame $exame)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Exame  $exame
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Exame $exame)
    {
        return PolicyPermission::permission($user, '3', 'exclui');
    }
}
