<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use Illuminate\Support\Str;

class StoreSetupController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if (!$user->canCreateStore()) {
            return redirect()->route('dashboard')->with('error', 'لا يمكنك إنشاء متجر');
        }
        
        return view('store.setup');
    }
    
    public function storeBasic(Request $request)
    {
        $user = auth()->user();
        
        if (!$user->canCreateStore()) {
            return redirect()->route('dashboard')->with('error', 'لا يمكنك إنشاء متجر');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:stores,name',
            'description' => 'nullable|string|max:1000',
        ]);
        
        $store = Store::create([
            'user_id' => $user->id,
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'is_active' => true,
            'is_verified' => false,
        ]);
        
        return response()->json([
            'success' => true,
            'store' => $store,
            'message' => 'تم إنشاء المتجر بنجاح',
        ]);
    }
    
    public function storeBranding(Request $request)
    {
        $user = auth()->user();
        $store = $user->store;
        
        if (!$store) {
            return response()->json(['success' => false, 'message' => 'المتجر غير موجود'], 404);
        }
        
        $validated = $request->validate([
            'logo' => 'nullable|image|max:2048',
            'cover_image' => 'nullable|image|max:5120',
        ]);
        
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('stores/logos', 'public');
            $store->update(['logo' => $logoPath]);
        }
        
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('stores/covers', 'public');
            $store->update(['cover_image' => $coverPath]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'تم تحديث صور المتجر',
        ]);
    }
    
    public function storeContact(Request $request)
    {
        $user = auth()->user();
        $store = $user->store;
        
        if (!$store) {
            return response()->json(['success' => false, 'message' => 'المتجر غير موجود'], 404);
        }
        
        $validated = $request->validate([
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'messenger' => 'nullable|string|max:50',
            'facebook' => 'nullable|string|max:100',
            'instagram' => 'nullable|string|max:100',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
        ]);
        
        $store->update($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'تم تحديث معلومات الاتصال',
        ]);
    }
}
