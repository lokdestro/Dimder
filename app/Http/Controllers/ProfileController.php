<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function saveStorageProfile($requestFile, $user_id)
    {
        $path = $requestFile->store($user_id, 'public');
        if ($path) {
            return $path;
        }
        return null;
    }
    public function getProfile($user_id)
    {
        $profile = Profile::where('user_id', $user_id)->first();

        if (!$profile) {
            return response()->json(['message' => 'Profile not found'], 404);
        }

        return response()->json($profile, 200);
    }
    public function updateProfile(Request $request, $user_id)
    {
        Log::info(1);
        $profile = Profile::where('user_id', $user_id)->first();
        $x = $request->all();

        if($request->hasFile('imageProfile') ) {
            Log::info(22);
            $fileZap = $this->saveStorageProfile($request->file('imageProfile'), $user_id);
            if (!is_null($fileZap)){
                $x['photo'] = 'https://lokdestro.ru' . Storage::url($fileZap) ;
            }
        }

        Log::info(2);
        if (!$profile) {
            return response()->json(['message' => 'Profile not found'], 404);
        }
        Log::info($x);

        $profile->update($x);
        Log::info(4);
        return response()->json($profile, 200);
    }
}
