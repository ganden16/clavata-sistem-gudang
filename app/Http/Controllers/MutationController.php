<?php

namespace App\Http\Controllers;

use App\Http\Resources\MutationResource;
use App\Models\Mutation;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class MutationController extends BaseController
{
	public function __construct()
	{
		$this->middleware(['auth:sanctum']);
	}

	public function index()
	{
		return MutationResource::collection(Mutation::paginate(15));
	}

	public function mutationProduct($productId)
	{
		$mutations = Mutation::where('product_id', $productId)->orderBy('updated_at', 'desc')->paginate(15);
		return MutationResource::collection($mutations);
	}

	public function mutationUser($userId)
	{
		$mutations = Mutation::where('user_id', $userId)->orderBy('updated_at', 'desc')->paginate(15);
		return MutationResource::collection($mutations);
	}

	public function store(Request $request)
	{
		Validator::make($request->all(), [
			'product_id' => 'required|exists:products,id',
			'type' => [
				'required',
				'in:' . implode(',', Mutation::TYPES_OPTIONS)
			],
			'date' => 'required|date_format:Y-m-d',
			'time' => 'required|date_format:H:i:s',
			'amount' => 'required|numeric',
			'description' => 'nullable|string',
		], [
			'required' => ':attribute tidak boleh kosong',
			'min' => 'minimal :min karakter',
			'in' => ':attribute tidak valid',
			'numeric' => 'harus angka',
			'time.date_format' => 'format :attribute tidak valid, gunakan format H:i:s',
			'date.date_format' => 'format :attribute tidak valid, gunakan format Y-m-d',
			'exists' => ':attribute tidak ditemukan',
		])->validate();

		Mutation::create([
			'user_id' => $request->user()->id,
			'product_id' => $request->product_id,
			'type' => $request->type,
			'date' => $request->date,
			'time' => $request->time,
			'amount' => $request->amount,
			'description' => $request->description,
		]);

		return response()->json([
			'message' => 'Data mutasi berhasil ditambahkan',
		], 201);
	}

	public function show(Mutation $mutation)
	{
		return new MutationResource($mutation);
	}

	public function update(Request $request, Mutation $mutation)
	{
		Validator::make($request->all(), [
			'product_id' => 'required|exists:products,id',
			'type' => [
				'required',
				'in:' . implode(',', Mutation::TYPES_OPTIONS)
			],
			'date' => 'required|date_format:Y-m-d',
			'time' => 'required|date_format:H:i:s',
			'amount' => 'required|numeric',
			'description' => 'nullable|string',
		], [
			'required' => ':attribute tidak boleh kosong',
			'min' => 'minimal :min karakter',
			'in' => ':attribute tidak valid',
			'numeric' => 'harus angka',
			'time.date_format' => 'format :attribute tidak valid, gunakan format H:i:s',
			'date.date_format' => 'format :attribute tidak valid, gunakan format Y-m-d',
			'exists' => ':attribute tidak ditemukan',
		])->validate();

		$mutation->update([
			'user_id' => $request->user()->id,
			'product_id' => $request->product_id,
			'type' => $request->type,
			'date' => $request->date,
			'time' => $request->time,
			'amount' => $request->amount,
			'description' => $request->description,
		]);

		return response()->json([
			'message' => 'Data mutasi berhasil diperbarui',
		], 200);
	}

	public function destroy(Mutation $mutation)
	{
		$mutation->delete();
		return response()->json([
			'message' => 'Data mutasi berhasil dihapus',
		], 200);
	}
}
