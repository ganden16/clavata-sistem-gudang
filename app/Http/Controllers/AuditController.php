<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use Illuminate\Routing\Controller as BaseController;

class AuditController extends BaseController
{
	public function __construct()
	{
		$this->middleware(['auth:sanctum']);
	}

	public function auditProduct($productId)
	{
		$audits = Audit::where('auditable_type', 'App\Models\Product')->where('auditable_id', $productId)->orderBy('updated_at', 'desc')->paginate(15);
		return response()->json(['data' => $audits], 200);
	}

	public function auditCategory($categoryId)
	{
		$audits = Audit::where('auditable_type', 'App\Models\Category')->where('auditable_id', $categoryId)->orderBy('updated_at', 'desc')->paginate(15);
		return response()->json(['data' => $audits], 200);
	}
}
