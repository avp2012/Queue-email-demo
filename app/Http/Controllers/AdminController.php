<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class AdminController extends Controller {
	//
	public function index(Request $request) {
		try {
			return view('backend.dashboard');
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}
}
