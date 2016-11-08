<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use \App\Alert as Alert;
use Input;

class SuperuserController extends Controller
{

	public function manage_permissions()
	{
		// must be superuser
		if (!Auth::user()->hasRole('superuser')) {
			Alert::error('Non hai i permessi per accedere a questa pagina');
			return redirect()->back();
		}

		$table = '<tr><th></th>';
		foreach (\App\Permission::all() as $permission) {
			$table .= '<th style="text-align:center">'.ucwords($permission->name).'</th>';
		}
		$table .= '</tr>';
		foreach (\Spatie\Permission\Models\Role::all() as $role) {
			$table .= '<tr><th>'.ucwords($role->name).'</th>';
			foreach (\App\Permission::all() as $permission) {
				$table .= '<td style="text-align:center">';
				if ($role->hasPermissionTo($permission->name)) 
					$checked = 'checked="checked"';
				else
					$checked = '';

				$permission_name = str_replace(' ', '_', $permission->name);
				$table .= '<input type="checkbox" class="icheckbox" name="'.$role->id.'-'.$permission_name.'" value="to_activate" '.$checked.'></td>';
			}
		}

		return view('superuser.permissions', compact('table'));
	}

	public function save_manage_permissions()
	{
		$array = Input::all();
		unset($array['_token']);
		// delete all permissions
		\App\PermissionRole::query()->truncate();
		foreach ($array as $k=>$v) {
			$new_str = explode('-', $k);
			$role = \Spatie\Permission\Models\Role::find($new_str[0]);
			$permission_name = str_replace('_', ' ', $new_str[1]);
			$role->givePermissionTo($permission_name);
		}
		Alert::success('Modifica effettuata con successo');
		return redirect()->back();
	}

}