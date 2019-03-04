<?php

namespace App\Policies;

use App\Permission;
use App\Registration;
use App\User;
use Exception;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResultListPolicy {
	use HandlesAuthorization;

	/**
	 * Determine whether the user can view the registration.
	 *
	 * @param  \App\User  $user
	 * @return mixed
	 */
	public function view(User $user) {
		try {
			$permissionRule = Permission::where('name', 'ResultList-View')->first();
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
	 * Determine whether the user can create registrations.
	 *
	 * @param  \App\User  $user
	 * @return mixed
	 */
	public function create(User $user) {
		//
	}

	/**
	 * Determine whether the user can update the registration.
	 *
	 * @param  \App\User  $user
	 * @param  \App\Registration  $registration
	 * @return mixed
	 */
	public function update(User $user, Registration $registration) {
		//
	}

	/**
	 * Determine whether the user can delete the registration.
	 *
	 * @param  \App\User  $user
	 * @param  \App\Registration  $registration
	 * @return mixed
	 */
	public function delete(User $user, Registration $registration) {
		//
	}

	/**
	 * Determine whether the user can restore the registration.
	 *
	 * @param  \App\User  $user
	 * @param  \App\Registration  $registration
	 * @return mixed
	 */
	public function restore(User $user, Registration $registration) {
		//
	}

	/**
	 * Determine whether the user can permanently delete the registration.
	 *
	 * @param  \App\User  $user
	 * @param  \App\Registration  $registration
	 * @return mixed
	 */
	public function forceDelete(User $user, Registration $registration) {
		//
	}
}
