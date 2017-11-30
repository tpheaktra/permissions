<?php

namespace App\Http\Controllers;

use App\Model\PermissionRoleModel;
use Illuminate\Http\Request;
use App\Model\Role;
use App\Model\Permission;
use DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$roles = Role::all();
        return view('admin.role-index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$permissions    = Permission::all();
		$permission_sub = DB::select('select distinct parent_id From tbl36b12_permissions');
        return view('admin.role-create',compact('permissions','permission_sub'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		//dd($request->all());
		 $this->validate($request, [
				'display_name' => 'required',
				'name' => 'required',
				'permission' => 'required',

			]);
		$role = Role::create($request->except(['permission','_token']));
        
		foreach($request->permission as $key=> $value){
			$role->attachPermission($value);
		}
		
		return back()->with('success','Data Inset successfuly.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$role = Role::find($id);
        $permissions = Permission::all();
		$role_permissions = $role->perms()->pluck('id','id')->toArray();
        $permission_sub = DB::select('select distinct parent_id From tbl36b12_permissions');
        return view('admin.role-edit',compact('permissions','role','role_permissions','permission_sub'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		        $this->validate($request, [

						'display_name' => 'required',
						'permission' => 'required',
					]);



		
        $role = Role::find($id);
		$role->display_name = $request->display_name;
		$role->save();
        PermissionRoleModel::where('role_id',$id)->delete();
		foreach($request->permission as $key=> $value){
			$role->attachPermission($value);
		}
		return back()->with('success','Data bas been update successsfuly');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::where('id',$id)->delete();
		return back()->with('success','Role delete successsfuly');
    }
}
