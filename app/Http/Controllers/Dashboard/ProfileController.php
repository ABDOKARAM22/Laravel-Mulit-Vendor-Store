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
        $user = Auth::guard('admin')->user();
        $user->load('profile');
        return view('dashboard.profile.edit',[
            'user'=>$user,
            'countries' => Countries::getNames(),
            'languages' => Languages::getNames()
        ]);
    }

    public function update(Request $request, MediaUploader $media)
    {
        $admin = $request->user('admin');
        $profile = $admin->profile()->firstOrNew();
        $validatedData = $request->validate(Profile::ProfileValidate($profile));
    
        if ($request->hasFile('image')) {
    
            $imagePath = $media->store($request->file('image'), 'profile_images');
    
            if ($profile->image) {
                $media->delete($profile->image);
            }
    
            $validatedData['image'] = $imagePath;
        }
    
        $profile->fill($validatedData);
        $profile->admin_id = $admin->id;
        $profile->save();
    
        return redirect()->route('dashboard.profile.edit')->with('success', 'Profile Updated Successfully.');
    }
    
}
