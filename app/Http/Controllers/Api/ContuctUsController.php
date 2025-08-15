<?php

namespace App\Http\Controllers\Api;

use App\Models\CountactUs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContuctUsController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:api', );
    }

    //

    // public function index()
    // {
    //     try{
    //         $countact_us = CountactUs::with('user')->get();

    //         return response()->json(['status'=>"true",'data' => $countact_us], 200);

    //     }catch (\Exception $e) {
    //         return response()->json(['status' => "false", 'error' => 'Failed to retrieve contact us data.'], 500);
    //     }
    // }


    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
        ]);

        try {
            $contactUs = CountactUs::create([
                'description' => $request->description,
                'user_id' => auth()->id(),
            ]);

            return response()->json(['status' => "true", 'data' => $contactUs->load('user'), 'msg' => 'سيتم مراجعة الطلب ف اسرع  وقت والرد عليكم اهلا بكم معنا ونرحب بكم'], 201);
        } catch (\Exception $e) {
            return response()->json(['status' => "false", 'error' => 'Failed to create contact us entry.'], 500);
        }
    }


    public function show($id)
    {
        try {
            $contactUs = CountactUs::with('user')->find($id);

            return response()->json(['status' => "true", 'data' => $contactUs], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => "false", 'error' => 'Contact us entry not found.'], 404);
        }
    }
    // public function changeStatus(CountactUs $countact_us, $status)
    // {
    //     try {
    //         $countact_us->status = $status;
    //         $countact_us->save();
    //         return response()->json(['status' => "true", 'data' => $countact_us], 200);
    //     } catch (\Exception $e) {
    //         return response()->json(['status' => "false", 'error' => 'Failed to change status.'], 500);
    //     }

    // }



}
