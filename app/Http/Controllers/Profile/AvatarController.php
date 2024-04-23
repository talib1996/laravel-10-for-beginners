<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAvatarRequest;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
    //
    public function update(UpdateAvatarRequest $request){
        // dd($request->file('avatar'));
        if ($old_avatar = $request->user()->avatar){
            Storage::disk('public')->delete($old_avatar);
        }
        $path = Storage::disk('public')->put('avatars', $request->file('avatar'));
        auth()->user()->update(['avatar'=> $path]);

        return redirect(route("profile.edit"))->with('status', 'Avatar updated!');
    }
    
}
