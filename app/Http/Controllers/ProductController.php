<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends BaseController
{
	public function __construct()
	{
		$this->middleware(['auth:sanctum'])->except('index', 'show');
	}

	public function index(Request $request)
	{
		$search = $request->input('search');

		if ($search) {
			$projects = Product::search($search)->query(function ($builder) {
				$builder->with(['category']);
			})->paginate(15);
		} else {
			$projects = Product::with(['category'])->paginate(15);
		}
		return ProductResource::collection($projects);
	}

	public function store(Request $request)
	{
		Validator::make($request->all(), [
			'name' => 'required',
			'description' => 'nullable|min:10',
			'category_id' => 'required|exists:categories,id',
			'location' => 'required',
			'fileImage' => 'image|max:5000',
			'unit' => [
				'required',
				'in:' . implode(',', Product::UNIT_OPTIONS)
			],
		], [
			'required' => 'tidak boleh kosong',
			'min' => 'minimal :min karakter',
			'in' => ':attribute tidak valid',
			'category_id.exists' => ':attribute tidak valid',
			'fileImage' => 'file harus gambar (jpeg, png, bmp, gif, or svg) dan ukuran maksimal 5 MB.',
		])->validate();

		$urlImage = null;
		if ($request->hasFile('fileImage')) {
			$path = $request->fileImage->store('images/products');
			$urlImage = Storage::url($path);
		}

		Product::create([
			'name' => $request->name,
			'description' => $request->description,
			'category_id' => $request->category_id,
			'location' => $request->location,
			'unit' => $request->unit,
			'image' => $urlImage,
		]);

		return response()->json([
			'message' => 'Data produk berhasil ditambahkan',
		], 201);
	}

	public function show(Product $product)
	{
		return new ProductResource($product);
	}

	public function update(Request $request, Product $product)
	{
		Validator::make($request->all(), [
			'name' => 'required',
			'description' => 'nullable|min:10',
			'category_id' => 'required',
			'location' => 'required',
			'fileImage' => 'image|max:5000',
			'unit' => [
				'required',
				'in:' . implode(',', Product::UNIT_OPTIONS)
			],
		], [
			'required' => 'tidak boleh kosong',
			'min' => 'minimal :min karakter',
			'in' => ':attribute tidak valid',
			'fileImage' => 'file harus gambar (jpeg, png, bmp, gif, or svg) dan ukuran maksimal 5 MB.',
		])->validate();

		$image = $product->image ?? null;
		if ($request->hasFile('fileImage')) {
			if ($product->image) {
				$urlImage = explode("/storage", $image, 2);
				$path =  $urlImage[1];
				Storage::delete($path);
			}
			$path = $request->fileImage->store('images/products');
			$image = Storage::url($path);
		}

		$product->update([
			'name' => $request->name,
			'description' => $request->description,
			'category_id' => $request->category_id,
			'location' => $request->location,
			'unit' => $request->unit,
			'image' => $image,
		]);

		return response()->json([
			'message' => 'Data produk berhasil diperbarui',
		], 200);
	}

	public function destroy(Product $product)
	{
		$product->delete();
		return response()->json([
			'message' => 'Data produk berhasil dihapus',
		], 200);
	}

	public function trashed()
	{
		$products = Product::query()->orderBy('updated_at', 'desc')->onlyTrashed()->paginate(15);
		return ProductResource::collection($products);
	}

	public function restore($id)
	{
		$product = Product::query()->onlyTrashed()->findOrFail($id);
		$product->restore();
		return response()->json(['message' => 'Data produk berhasil dikembalikan']);
	}
}
