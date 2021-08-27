<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use DB;
use Validation;

class RoleController extends Controller
{
	function __construct()
	{
		$this->setTitle("Peran");
		$this->setUrl("role");
	}

  public function index()
	{
		$this->setBreadcrumb(['Master Data' => '#', 'Peran' => '#']);
		return $this->render('role.index');
	}

	public function grid(Request $request)
	{
		$data = Role::all();
		return datatables()->of($data)->toJson();
	}

	public function edit(request $request, $id = null)
	{
		$data = Role::find($id);
		if($data == null){
			$data = new \stdClass();
			$data->id = null;
			$data->name = null;
		}

		$perms = Permission::all()->pluck('name');
		// get role permissions granted
		$hasPermission = DB::table('role_has_permissions')
			->select('permissions.name')
			->join('permissions', 'role_has_permissions.permission_id', 'permissions.id')
			->where('role_id', $id)->get()->pluck('name')->all();
		
		$arrPerms = array();
		foreach($perms as $key => $perm){
			$module = explode('-', $perm);
			$uppModule = ucwords($module[0]);
			if(!isset($arrPerms[$uppModule])){
				$arrPerms[$uppModule] = $uppModule; 
				
				$arrPerms[$uppModule] = new \stdClass();
				$arrPerms[$uppModule]->module = $uppModule;
				$arrPerms[$uppModule]->actions = array();
			}

			$action = new \stdClass();
			$action->raw = $module[1];
			$action->value = $perm;
			$action->active = in_array($perm, $hasPermission) ? true : false;
			array_push($arrPerms[$uppModule]->actions, $action);
		}
		ksort($arrPerms);
		
		$data->user = $data->id != null ? User::role($data->name)->get() : [] ;
		$results = array(
			'data' => $data,
			'perms' => $arrPerms
		);

		$label = $data != null ? 'Ubah' : 'Tambah Baru';
		$this->setBreadcrumb(['Master Data' => '#', 'Role' => '/role', $label => '#']);
		return $this->render('role.edit', $results);
	}

	public function save(request $request)
	{
		$request->validate([
			'name' => 'required',
		]);
		
		if(isset($request->id)){
			$role = Role::find($request->id);
			$role->name = $request->name;
			$role->save();

			$role->syncPermissions($request->roleperms);
			$status = 'Berhasil mengubah peran.';
		} else {
			$role = Role::create([
				'name' => $request->name,
				'guard' => 'web'
			]);
			
			$role->givePermissionTo($request->roleperms);
			$status = 'Berhasil menambahkan peran baru.';
		}

		$request->session()->flash('success', $status);
		return redirect('/role');
	}

	public function delete($id)
	{
		$role = Role::destroy($id);

		$results = array(
			'status' => 'success',
			'action' => 'Hapus Peran',
			'messages' => 'Peran berhasil dihapus'
		);

		return response()->json($results);
	}
}
