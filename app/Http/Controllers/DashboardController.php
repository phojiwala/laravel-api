<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DashboardItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
  public function index(Request $request)
  {
    $query = DashboardItem::query();

    // Search
    $searchTerm = $request->input('search');
    if ($searchTerm) {
      $query->where(function ($q) use ($searchTerm) {
        $q->where('title', 'like', "%{$searchTerm}%")
          ->orWhere('price', 'like', "%{$searchTerm}%")
          ->orWhere('description', 'like', "%{$searchTerm}%")
          ->orWhere('category', 'like', "%{$searchTerm}%");
      });
    }

    // Sorting
    $sortField = $request->input('sort_by', 'id');
    $sortDirection = $request->input('sort_direction', 'asc');
    $query->orderBy($sortField, $sortDirection);

    // Pagination
    $perPage = $request->input('per_page', 10);
    $items = $query->paginate($perPage);
    return response()->json([
      'data' => $items->items(),
      'current_page' => $items->currentPage(),
      'per_page' => $items->perPage(),
      'total' => $items->total(),
      'last_page' => $items->lastPage(),
    ]);
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'title' => 'required|string|max:255',
      'price' => 'required|numeric|min:0',
      'description' => 'required|string',
      'category' => 'required|string|max:255',
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 400);
    }
    $item = DashboardItem::create($request->all());
    return response()->json($item, 201);
  }
}
