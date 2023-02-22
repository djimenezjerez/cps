<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('combo')) {
            return response()->json([
                'message' => 'Lista de registros',
                'payload' => DB::table('users')->select('id', 'name', 'username')->orderBy('name')->get(),
            ]);
        }

        $user = Auth::user();
        $query = DB::table('users')->select('id', 'username', 'name')->where('id', '!=', $user->id);
        if ($request->has('sort_by') && $request->has('sort_desc')) {
            foreach ($request->sort_by as $i => $sort) {
                $query->orderBy($sort, filter_var($request->sort_desc[$i], FILTER_VALIDATE_BOOLEAN) ? 'DESC' : 'ASC');
            }
        } else {
            $query->orderBy('name');
        }

        if ($request->has('search')) {
            if (strlen($request->search) > 0) {
                $query->where(function($q) use ($request) {
                    return $q->orWhere(DB::raw('upper(name)'), 'like', '%'.trim(mb_strtoupper($request->search)).'%')->orWhere(DB::raw('upper(username)'), 'like', '%'.trim(mb_strtoupper($request->search)).'%');
                });
            }
        }

        return response()->json([
            'message' => 'Lista de registros',
            'payload' => $query->paginate($request->per_page ?? 8, ['*'], 'page', $request->page ?? 1),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:255'],
            'username' => ['required', 'string', 'min:5', 'max:255', 'unique:users,username'],
            'password' => ['required', 'string', 'min:5', 'max:255'],
        ]);
        $user = User::create($request->all());
        return response()->json([
            'message' => 'Registro almacenado',
            'payload' => $user,
        ]);
    }

    public function show(User $user)
    {
        return response()->json([
            'message' => 'Detalle del registro',
            'payload' => $user,
        ]);
    }

    public function update(Request $request, User $user)
    {
        if (Auth::user()->id == $user->id) {
            $request->validate([
                'old_password' => ['required', 'current_password:api'],
                'password' => ['required', 'confirmed', 'string', 'min:5', 'max:255'],
            ]);
            $user->update([
                'password' => $request->password,
            ]);
        } else {
            $request->validate([
                'name' => ['sometimes', 'required', 'string', 'min:5', 'max:255'],
                'username' => ['sometimes', 'required', 'string', 'min:5', 'max:255', 'unique:users,username,'.$user->id],
                'password' => ['sometimes', 'required', 'string', 'min:5', 'max:255'],
            ]);
            $user->update($request->all());
            if ($request->has('username') || $request->has('password')) {
                $user->tokens()->delete();
                $user->setRememberToken(null);
                $user->save();
            }
        }
        return response()->json([
            'message' => 'Registro modificado',
            'payload' => $user,
        ]);
    }

    public function destroy(User $user)
    {
        $user->tokens()->delete();
        $user->delete();
        return response()->json([
            'message' => 'Registro eliminado',
            'payload' => $user,
        ]);
    }
}
