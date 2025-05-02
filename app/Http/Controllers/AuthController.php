<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
	public function __construct()
	{
		$this->middleware(['auth:sanctum'])->except(['login']);
	}

	public function me(Request $request)
	{
		return new UserResource($request->user());
	}

	public function login(Request $request)
	{
		Validator::make($request->all(), [
			'username' => 'required',
			'password' => 'required|min:6',
		], [
			'required' => 'tidak boleh kosong',
			'min' => 'minimal :min karakter',
		])->validate();

		$credentials = [
			'username' => $request->username,
			'password' => $request->password,
		];

		if (!Auth::attempt($credentials)) {
			return response()->json(['message' => 'Username atau password salah'], 401);
		}

		$user = Auth::user();
		$user->tokens()->delete();
		$token = $user->createToken('sistem-gudang')->plainTextToken;

		return response()->json([
			'token' => $token,
			'message' => 'Berhasil login',
		], 200);
	}

	public function logout(Request $request)
	{
		$request->user()->currentAccessToken()->delete();
		return response()->json([
			'message' => 'Anda telah logout'
		], 200);
	}

	public function updateProfile(Request $request)
	{
		$user = $request->user();
		$gender = $request->gender == 'true' || true || 1 ? true : false;

		Validator::make($request->all(), [
			'name' => 'required',
			'username' => 'required|unique:users,username,' . $user->id,
			'email' => 'nullable|email|unique:users,email,' . $user->id,
			'whatsapp' => 'nullable|numeric',
			'telephone' => 'nullable|numeric',
			'gender' => 'required',
			'fileImage' => 'nullable|image|max:5000',
		], [
			'required' => 'tidak boleh kosong',
			'numeric' => 'harus berupa angka',
			'unique' => ':attribute telah terdaftar, gunakan :attribute lain',
			'email.email' => 'harus email valid',
			'fileImage' => 'file harus gambar (jpeg, png, bmp, gif, or svg) dan ukuran maksimal 5 MB.',
		])->validate();

		$image = $user->image ?? null;

		if ($request->hasFile('fileImage')) {
			if ($user->image) {
				$urlImage = explode("/storage", $image, 2);
				$path =  $urlImage[1];
				Storage::delete($path);
			}
			$path = $request->fileImage->store('images/profiles');
			$image = Storage::url($path);
		}
		$user->update([
			'name' => $request->name,
			'username' => $request->username,
			'email' => $request->email,
			'address' => $request->address,
			'telephone' => $request->telephone,
			'whatsapp' => $request->whatsapp,
			'gender' => $gender,
			'religion' => $request->religion,
			'image' => $image,
		]);

		return response()->json([
			'message' => 'Profilmu berhasil diperbarui',
		], 200);
	}

	public function changePassword(Request $request)
	{
		$user = $request->user();

		$validator = Validator::make($request->all(), [
			'currentPassword' => [
				'required',
				function ($attribute, $value, $fail) use ($user) {
					if (!Hash::check($value, $user->password)) {
						$fail('Password lama tidak sesuai.');
					}
				},
			],
			'password' => 'required|confirmed|min:6',
		], [
			'required' => 'tidak boleh kosong.',
			'min' => 'minimal :min karakter.',
			'confirmed' => 'konfirmasi password tidak cocok',
		]);

		$validator->validate();
		$user->update([
			'password' => Hash::make($request->password),
		]);

		return response()->json([
			'message' => 'Password berhasil diubah',
		], 200);
	}
}
