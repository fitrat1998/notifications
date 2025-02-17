<?php

namespace App\Http\Controllers;

use App\Models\admin\Department;
use App\Models\admin\Faculty;
use App\Models\Role;
use App\Models\studydepartament\StudyDepartament;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if_forbidden('user.show');

        $users = User::where('id', '!=', auth()->user()->id)->get();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if_forbidden('user.add');

//        if (auth()->user()->hasRole('Super Admin'))
//            $roles = Role::all();
//        else
        $departments = Department::all();
        $roles = Role::where('name', '!=', 'Super Admin')->get();

        return view('admin.users.add', compact('roles', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if_forbidden('user.add');

        $this->validate($request, [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'middlename' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string'],
            'login' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'department_id' => ['nullable', 'integer'],
        ]);

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'middlename' => $request->middlename,
            'position' => $request->position,
            'login' => $request->login,
            'email' => $request->email,
            'department_id' => $request->department_id ? (int)$request->department_id : null,
            'password' => Hash::make($request->get('password')),
        ]);


        $role_cnt = Role::count();

        if ($role_cnt != 0 && $role_cnt < 2) {
            Role::create([
                'name' => 'user',
                'title' => 'User',
                'guard_name' => 'we b'
            ]);
        }

        $user->assignRole('user');


        return redirect()->route('users.index')->with('success', 'Foydalanuvchi muvaffaqiyatli qo`shildi');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        abort_if((!auth()->user()->can('user.edit') && auth()->id() != $id), 403);
        $user = User::find($id);
        $departments = Department::all();


        if ($user->hasRole('Super Admin') && !auth()->user()->hasRole('Super Admin')) {
            message_set("У вас нет разрешения на редактирование администратора", 'error', 5);
            return redirect()->back();
        }


        $roles = Role::where('name', '!=', 'Super Admin')->get();

        return view('admin.users.edit', compact('user', 'roles', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if((!auth()->user()->can('user.edit') && auth()->id() != $id), 403);

        $this->validate($request, [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'middlename' => ['required', 'string', 'max:255'],
            'position' => ['string'],
            'login' => ['required', 'string', 'max:255', 'unique:users,login,' . $id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'department_id' => ['nullable', 'integer'],
        ]);

        $user = User::find($id);

        $data = [
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'middlename' => $request->middlename,
            'position' => $request->position,
            'login' => $request->input('login'),
            'email' => $request->input('email'),
            'department_id' => $request->input('department_id'),
            'updated_at' => now(),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }

        $user->update($data);

        if (isset($request->roles)) {
            $user->syncRoles($request->get('roles'));
        }

        return redirect()->route('users.index')->with('success', 'Foydalanuvchi muvaffaqiyatli tahrirlandi');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if_forbidden('user.delete');

        $user = User::destroy($id);

        if (auth()->user()->roles[0]->name == "Super Admin") {
            return redirect()->back()->with('error', 'Siz bu foydalanuvchini o`chira olmaysiz');
        }
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        DB::table('model_has_permissions')->where('model_id', $id)->delete();


        return redirect()->route('users.index')->with('success', 'Foydalanuvchi muvaffaqiyatli o`chirildi');
    }
}
