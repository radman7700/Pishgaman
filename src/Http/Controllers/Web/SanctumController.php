<?php

namespace Pishgaman\Pishgaman\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Pishgaman\Pishgaman\Database\Models\PersonalAccessToken;
use Illuminate\Support\Facades\Auth;

class SanctumController extends Controller
{
    public function setCsrfCookie(Request $request)
    {
        return response()->json(['message' => 'CSRF cookie set']);
    }

    public function getToken(Request $request)
    {
        if (Auth::check()) {
            $token = session('api_token');
            return ['token' => $token];
        } else {
            return response()->json(['message' => 'User not logged in'], 401);
        }
    }
}

