<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class CategoryController extends BaseController
{
	public function __construct()
	{
		$this->middleware('auth:sanctum')->except(['index', 'show']);
	}

	public function index()
	{
		return CategoryResource::collection(Category::all());
	}

	public function store(Request $request)
	{
		Validator::make($request->all(), [
			'name' => 'required',
			'description' => 'required|min:10',
		], [
			'required' => 'tidak boleh kosong',
			'min' => 'minimal :min karakter',
		])->validate();

		Category::create([
			'name' => $request->name,
			'description' => $request->description,
		]);

		return response()->json([
			'message' => 'Data kategori berhasil ditambahkan',
		], 201);
	}

	public function show(Category $category)
	{
		return new CategoryResource($category);
	}

	public function update(Request $request, Category $category)
	{
		Validator::make($request->all(), [
			'name' => 'required',
			'description' => 'required|min:10',
		], [
			'required' => 'tidak boleh kosong',
			'min' => 'minimal :min karakter',
		])->validate();

		$category->update([
			'name' => $request->name,
			'description' => $request->description,
		]);

		return response()->json([
			'message' => 'Data kategori berhasil diupdate',
		], 200);
	}

	public function destroy(Category $category)
	{
		$category->delete();
		
		return response()->json([
			'message' => 'Data kategori berhasil dihapus',
		], 200);
	}
}
