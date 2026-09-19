<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Log;

class Register extends Component
{
    public $name;
    public $phone;
    public $email;
    public $password;
    public $role = 'buyer';

    protected function rules()
    {
        return [
            'name'     => 'required|string|min:3|max:100',
            'phone'    => ['required', 'string', 'unique:users,phone', 'regex:/^0[567][0-9]{8}$/'],
            'role'     => 'required|in:buyer,vendor',
            'email'    => $this->role === 'vendor' 
                          ? 'required|email|unique:users,email' 
                          : 'nullable|email|unique:users,email',
            'password' => $this->role === 'vendor' 
                          ? ['required', Password::min(8)->letters()->numbers()] 
                          : 'nullable|min:6',
        ];
    }

    // رسائل خطأ مخصصة لتسهيل الـ Debug
    protected $messages = [
        'phone.regex' => 'رقم الهاتف يجب أن يكون جزائرياً صحيحاً (05, 06, 07).',
        'phone.unique' => 'هذا الرقم مسجل مسبقاً.',
        'email.required' => 'البريد الإلكتروني ضروري لحساب البائع.',
    ];

    public function register()
    {
        // 1. التحقق من البيانات
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            // إذا فشل الـ Validation، سيظهر الخطأ في الـ Blade بفضل @error
            throw $e; 
        }

        try {
            // 2. معالجة كلمة السر الافتراضية للمشتري
            $finalPassword = ($this->role === 'buyer' && empty($this->password)) 
                            ? '123456789' 
                            : $this->password;

            // 3. إنشاء المستخدم
            $user = User::create([
                'name'      => $this->name,
                'phone'     => $this->phone,
                'email'     => $this->email,
                'role'      => $this->role, 
                'password'  => Hash::make($finalPassword),
                'is_active' => true,
            ]);

            // 4. إسناد الدور (Spatie)
            if ($user && method_exists($user, 'assignRole')) {
                $user->assignRole($this->role);
            }

            // 5. تسجيل الدخول والتوجيه
            Auth::login($user);
            session()->regenerate();

            return redirect()->to(route('dashboard'));

        } catch (\Exception $e) {
            Log::error('TRICO Register Error: ' . $e->getMessage());
            
            // لإظهار الخطأ الحقيقي أثناء التطوير
            if (config('app.debug')) {
                dd($e->getMessage());
            }

            $this->addError('name', 'خطأ في النظام: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.auth.register')->layout('layouts.app');
    }
}