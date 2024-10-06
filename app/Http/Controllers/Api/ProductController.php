<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    
    public function parts (Request $request)
    {
        return Product::whereNotCombinations()
            ->withoutGlobalScopes()
            ->where(function ($query) use ($request) {
                $query->where('code', 'like', "%$request->search%")
                    ->orWhere('name', 'like', "%$request->search%");
            })
            ->when(!is_null($request->dimension_id), function ($query) use ($request) {
                $query->where('dimension_id', $request->dimension_id);
            })
            ->when(!is_null($request->type), function ($query) use ($request) {
                $query->where('type', $request->type);
            })
            ->select('id', 'name', 'code', 'type')
            ->get();
    }
}
