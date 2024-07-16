<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DashboardItem;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
  public function index(Request $request)
  {
    $query = DashboardItem::query();

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
}
