<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class Login extends Component
{
    // المتغيرات العامة المرتبطة بـ wire:model
    public $login;
    public $password;
    public $role = 'buyer'; // القيمة الافتراضية كما في الواجهة
    public $remember = false;

    // قواعد التحقق
    protected $rules = [
        'login'    => 'required|string',
        'password' => 'required|string',
    ];

    /**
     * عملية تسجيل الدخول وتوجيه المستخدم بناءً على رتبته
     */
    public function authenticate()
{
    $this->validate(['login' => 'required', 'password' => 'required']);

    // تحديد هل المدخل إيميل أم هاتف
    $fieldType = filter_var($this->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

    if (Auth::attempt([$fieldType => $this->login, 'password' => $this->password], $this->remember)) {
        session()->regenerate();
        
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // التوجيه الذكي الموحد:
        // بما أننا جعلنا مسار 'dashboard' هو المسؤول عن التوزيع في Controller
        // سنوجه الجميع إليه، وهو سيتكفل بالباقي.
        return redirect()->intended(route('dashboard'));
    }

    $this->addError('login', 'البيانات غير صحيحة.');
}

    public function render()
    {
        // تحديد الـ layout لضمان ظهور الصفحة كاملة
        return view('livewire.auth.login')
                ->layout('layouts.app');
    }
}