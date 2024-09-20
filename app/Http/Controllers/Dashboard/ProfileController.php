<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Intl\Languages;
use Symfony\Component\Intl\Countries;

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

    public function update(Request $request)
    {
        $validatedData = $request->validate(Profile::ProfileValidate());
    
        $user = $request->user();
        
        if ($request->hasFile('image')) {
    
            $imagePath = $request->file('image')->store('profile_images', 'uploads');
    
            if ($user->profile->image) {
                Storage::disk('uploads')->delete($user->profile->image);
            }
    
            $validatedData['image'] = $imagePath;
        }
    
        $user->profile->fill($validatedData)->save();
    
        return redirect()->route('dashboard.profile.edit')->with('success', 'Profile Updated Successfully.');
    }
    
}
