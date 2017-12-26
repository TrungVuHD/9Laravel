<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Report;
use App\Post;
use Validator;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'post_id' => 'required|integer',
            'reason' => 'required|integer'
        ]);

        if ($validation->fails()) {
            return ['success' => false];
        } else {
            $report =  new Report();
            $report->user_id = Auth::user()->id;
            $report->post_id = $request->post_id;
            $report->reason = $request->reason;

            $report->save();

            return ['success' => true];
        }
    }
}
