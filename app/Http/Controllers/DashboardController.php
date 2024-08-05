<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DashboardItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Facades\Log;

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
    $sortField = $request->input('sort_column', 'created_at');
    $sortDirection = $request->input('sort_direction', 'desc');
    if ($sortField === 'created_at') {
      $query->latest();
    } else {
      $query->orderBy($sortField, $sortDirection);
    }

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

  public function show($id)
  {
    $item = DashboardItem::findOrFail($id);
    return response()->json($item, 200);
  }

  public function destroy($id)
  {
    $item = DashboardItem::findOrFail($id);
    $item->delete();
    return response()->json(['message' => 'Item deleted successfully'], 200);
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'title' => 'required|string|max:255',
      'price' => 'required|numeric|min:0',
      'description' => 'required|string',
      'category' => 'required|string|max:255',
      'image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:5120',
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 400);
    }

    $data = $request->all();

    if ($request->hasFile('image')) {
      $file = $request->file('image');
      $path = $file->store('images', 'public');
      $data['image'] = '/storage/' . $path;
    }

    $item = DashboardItem::create($data);
    return response()->json($item, 201);
  }

  public function update(Request $request, $id)
  {
    $request->headers->set('Accept', 'application/json');
    $request->headers->set('Content-Type', 'application/json');

    \Log::info('Update request received for item ' . $id);
    \Log::info('Request method: ' . $request->method());
    \Log::info('Request content type: ' . $request->header('Content-Type'));
    \Log::info('Raw request content: ' . $request->getContent());
    \Log::info('Request data:', $request->all());
    \Log::info('Request input:', $request->input());

    $validator = Validator::make($request->all(), [
      'title' => 'sometimes|required|string|max:255',
      'price' => 'sometimes|required|numeric|min:0',
      'description' => 'sometimes|required|string',
      'category' => 'sometimes|required|string|max:255',
      'image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:5120',
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 400);
    }

    $item = DashboardItem::findOrFail($id);
    $data = $request->all();

    if ($request->hasFile('image')) {
      $file = $request->file('image');
      $path = $file->store('images', 'public');
      $item->image = '/storage/' . $path;
    } elseif ($request->has('image') && $request->input('image') === null) {
      $item->image = null;
    }

    $item->update($data);
    return response()->json($item, 200);
  }
}
