<?php

namespace App\Policies;

use App\Club;
use App\Permission;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClubPolicy {
	use HandlesAuthorization;

	/**
	 * Determine whether the user can view the club.
	 *
	 * @param  \App\User  $user
	 * @param  \App\Club  $club
	 * @return mixed
	 */
	public function view(User $user) {
		try {
			$permissionRule = Permission::where('name', 'Club-View')->first();
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
	 * Determine whether the user can create clubs.
	 *
	 * @param  \App\User  $user
	 * @return mixed
	 */
	public function create(User $user) {
		try {
			$permissionRule = Permission::where('name', 'Club-Create')->first();
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
	 * Determine whether the user can update the club.
	 *
	 * @param  \App\User  $user
	 * @param  \App\Club  $club
	 * @return mixed
	 */
	public function update(User $user) {
		try {
			$permissionRule = Permission::where('name', 'Club-Update')->first();
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
	 * Determine whether the user can delete the club.
	 *
	 * @param  \App\User  $user
	 * @param  \App\Club  $club
	 * @return mixed
	 */
	public function delete(User $user) {
		try {
			$permissionRule = Permission::where('name', 'Club-Delete')->first();
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
	 * Determine whether the user can restore the club.
	 *
	 * @param  \App\User  $user
	 * @param  \App\Club  $club
	 * @return mixed
	 */
	public function restore(User $user, Club $club) {
		//
	}

	/**
	 * Determine whether the user can permanently delete the club.
	 *
	 * @param  \App\User  $user
	 * @param  \App\Club  $club
	 * @return mixed
	 */
	public function forceDelete(User $user, Club $club) {
		//
	}
}
