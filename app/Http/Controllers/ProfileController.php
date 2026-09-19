<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }
    
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }
    
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'bio' => 'nullable|string|max:1000',
        ]);
        
        $user->update($validated);
        
        return redirect()->route('profile')->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }
    
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);
        
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة']);
        }
        
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        
        return redirect()->route('profile.edit')->with('success', 'تم تغيير كلمة المرور بنجاح');
    }
    
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|max:2048',
        ]);
        
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }
        
        $path = $request->file('avatar')->store('avatars/' . $user->id, 'public');
        
        $user->update(['avatar' => $path]);
        
        return redirect()->route('profile.edit')->with('success', 'تم تحديث الصورة الشخصية بنجاح');
    }
    
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);
        
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'كلمة المرور غير صحيحة']);
        }
        
        // Soft delete - mark as inactive
        $user->update(['is_active' => false]);
        
        Auth::logout();
        
        return redirect()->route('home')->with('success', 'تم حذف حسابك بنجاح');
    }
}
