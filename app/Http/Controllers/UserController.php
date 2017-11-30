<?php

namespace App\Http\Controllers;

use App\Model\RoleUserModel;
use Illuminate\Http\Request;
use DB;
use App\Model\Role;
use App\User;
use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $user = User::all();
       // $user = DB::select("SELECT id,name,email,date_format(created_at,'%d-%M-%Y, %h:%i:%s %p') as created_at,date_format(updated_at,'%d-%M-%Y, %h:%i:%s %p') as updated_at FROM tbl36b12_users");
        return view('admin.user-index',compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$roles = Role::all();
        return view('admin.user-create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
                $this->validate($request, [
						'name' => 'required',
						'email' => 'required|email|unique:tbl36b12_users,email',
						'password' => 'required|same:confirm-password',
						'roles' => 'required'
					]);


					$input = $request->all();
					$input['password'] = Hash::make($input['password']);
					$user = User::create($input);
					foreach ($request->input('roles') as $key => $value) {
						$user->attachRole($value);
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
            $user = User::find($id);
            $roles = Role::all();
            $userRole = $user->roles->pluck('id','id')->toArray();
            return view('admin.user-edit',compact('user','roles','userRole'));
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
            'name' => 'required',
            //'email' => 'required|email|unique:tbl36b12_users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = array_except($input,array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        RoleUserModel::where('user_id',$id)->delete();


        foreach ($request->input('roles') as $key => $value) {
            $user->attachRole($value);
        }

        return redirect()->route('user.index')
            ->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::where('id',$id)->delete();
        return back()->with('success','Users delete successsfuly');
    }
}
