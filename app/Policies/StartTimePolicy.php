<?php

namespace App\Policies;

use App\Permission;
use App\StartTime;
use App\User;
use Exception;
use Illuminate\Auth\Access\HandlesAuthorization;

class StartTimePolicy {
	use HandlesAuthorization;

	/**
	 * Determine whether the user can view the start time.
	 *
	 * @param  \App\User  $user
	 * @param  \App\StartTime  $startTime
	 * @return mixed
	 */
	public function view(User $user) {
		try {
			$permissionRule = Permission::where('name', 'StartTime-View')->first();
			if ($permissionRule == null) {$permissionRule->permission_ID = null;}
		} catch (\Exception $e) {
			$permissionRule->permission_ID = null;
		}
		foreach ($user->roles as $role) {
			foreach ($role->permissions as $permission) {
				if ($permission->permission_ID === $permissionRule->permission_ID) {
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * Determine whether the user can create start times.
	 *
	 * @param  \App\User  $user
	 * @return mixed
	 */
	public function create(User $user) {
		//
	}

	/**
	 * Determine whether the user can update the start time.
	 *
	 * @param  \App\User  $user
	 * @param  \App\StartTime  $startTime
	 * @return mixed
	 */
	public function update(User $user, StartTime $startTime) {
		//
	}

	/**
	 * Determine whether the user can delete the start time.
	 *
	 * @param  \App\User  $user
	 * @param  \App\StartTime  $startTime
	 * @return mixed
	 */
	public function delete(User $user, StartTime $startTime) {
		//
	}

	/**
	 * Determine whether the user can restore the start time.
	 *
	 * @param  \App\User  $user
	 * @param  \App\StartTime  $startTime
	 * @return mixed
	 */
	public function restore(User $user, StartTime $startTime) {
		//
	}

	/**
	 * Determine whether the user can permanently delete the start time.
	 *
	 * @param  \App\User  $user
	 * @param  \App\StartTime  $startTime
	 * @return mixed
	 */
	public function forceDelete(User $user, StartTime $startTime) {
		//
	}

	/**
	 * Determine whether the user can view the start time.
	 *
	 * @param  \App\User  $user
	 * @param  \App\StartTime  $startTime
	 * @return mixed
	 */
	public function generate(User $user) {
		try {
			$permissionRule = Permission::where('name', 'StartTime-Generate')->first();
			if ($permissionRule == null) {$permissionRule->permission_ID = null;}
		} catch (\Exception $e) {
			$permissionRule->permission_ID = null;
		}
		foreach ($user->roles as $role) {
			foreach ($role->permissions as $permission) {
				if ($permission->permission_ID === $permissionRule->permission_ID) {
					return true;
				}
			}
		}
		return false;
	}
}
