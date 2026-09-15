<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Intl\Languages;
use Symfony\Component\Intl\Countries;
use App\Services\MediaUploader;

class ProfileController extends Controller
{
    public function edit(){
        $user = Auth::user();
        return view('dashboard.profile.edit',[
            'user'=>$user,
            'countries' => Countries::getNames(),
            'languages' => Languages::getNames()
        ]);
    }

    public function update(Request $request, MediaUploader $media)
    {
        $validatedData = $request->validate(Profile::ProfileValidate());
    
        $user = $request->user();
        
        if ($request->hasFile('image')) {
    
            $imagePath = $media->store($request->file('image'), 'profile_images');
    
            if ($user->profile->image) {
                $media->delete($user->profile->image);
            }
    
            $validatedData['image'] = $imagePath;
        }
    
        $user->profile->fill($validatedData)->save();
    
        return redirect()->route('dashboard.profile.edit')->with('success', 'Profile Updated Successfully.');
    }
    
}
