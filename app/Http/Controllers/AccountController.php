<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
  public function index()
  {
    $accounts = Account::select('first_name', 'last_name', 'email', 'phone', 'status')
      ->paginate(10);

    return response()->json([
      'data' => $accounts->items(),
      'current_page' => $accounts->currentPage(),
      'last_page' => $accounts->lastPage(),
      'per_page' => $accounts->perPage(),
      'total' => $accounts->total()
    ]);
  }
}
