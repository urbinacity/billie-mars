<?php

namespace App\Http\Controllers;
use App\Models\MarsTime;
use Illuminate\Http\Request;

class MarsController extends Controller
{
    public function index(Request $request)
    {
        $utc = $request->input('utc');
        try {
            $mars_time = new MarsTime($utc);
        } catch (\Throwable $th) {
            return response('Invalid UTC argument received', 400);
        }

        return response()->json([
            'mars_sol_date' => $mars_time->msd(),
            'mars_coordinated_time' => $mars_time->h_to_hms($mars_time->mtc()),
        ]);
    }
}
