<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as BaseController;

class UserController extends BaseController
{
	public function __construct()
	{
		$this->middleware(['auth:sanctum', 'admin']);
	}

	public function index()
	{
		$users = User::orderBy('updated_at', 'desc')->paginate(15);
		return UserResource::collection($users);
	}

	public function store(Request $request)
	{
		Validator::make($request->all(), [
			'name' => 'required',
			'username' => 'required|unique:users,username',
			'password' => 'required|min:6|confirmed',
		], [
			'required' => 'tidak boleh kosong',
			'min' => 'minimal :min karakter',
			'username.unique' => ':attribute telah terdaftar, gunakan :attribute lain'
		])->validate();

		User::create([
			'name' => $request->name,
			'username' => $request->username,
			'password' => Hash::make($request->password),
		]);

		return response()->json([
			'message' => 'Data user berhasil ditambahkan',
		], 201);
	}

	public function show(User $user)
	{
		return new UserResource($user);
	}

	//promote user to admin
	public function update(Request $request, User $user)
	{
		if ($user->is_admin) {
			return response()->json(['message' => 'anda sesama admin :)'], 200);
		}

		$user->update([
			'is_admin' => true
		]);

		return response()->json([
			'message' => 'User berhasil dipromosikan menjadi admin',
		], 200);
	}

	public function destroy(User $user)
	{
		if ($user->is_admin) {
			return response()->json(['message' => 'anda sesama admin :)'], 200);
		}
		$user->delete();
		return response()->json([
			'message' => 'User berhasil diblokir',
		], 200);
	}

	public function trashed()
	{
		$users = User::query()->orderBy('updated_at', 'desc')->onlyTrashed()->paginate(15);
		return UserResource::collection($users);
	}

	public function restore($id)
	{
		$user = User::query()->onlyTrashed()->findOrFail($id);
		$user->restore();
		return response()->json(['message' => 'User berhasil dikembalikan']);
	}
}
