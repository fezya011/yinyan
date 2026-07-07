<?php
// app/Http/Controllers/Admin/NotificationSettingsController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotificationEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class NotificationSettingsController extends Controller
{
    public function index()
    {
        Gate::forUser(auth('admin')->user())->authorize('admin');

        $emails = NotificationEmail::orderBy('created_at')->get();

        return view('admin.settings.notifications', compact('emails'));
    }

    public function store(Request $request)
    {
        Gate::forUser(auth('admin')->user())->authorize('admin');

        $request->validate([
            'email' => ['required', 'email', 'unique:notification_emails,email'],
            'name' => ['nullable', 'string', 'max:255'],
        ]);

        NotificationEmail::create([
            'email' => $request->email,
            'name' => $request->name,
            'is_active' => true,
        ]);

        return redirect()
            ->route('admin.settings.notifications')
            ->with('success', 'Email для уведомлений добавлен');
    }

    public function update(Request $request, NotificationEmail $notificationEmail)
    {
        Gate::forUser(auth('admin')->user())->authorize('admin');

        $request->validate([
            'email' => ['required', 'email', Rule::unique('notification_emails', 'email')->ignore($notificationEmail->id)],
            'name' => ['nullable', 'string', 'max:255'],
        ]);

        $notificationEmail->update([
            'email' => $request->email,
            'name' => $request->name,
        ]);

        return redirect()
            ->route('admin.settings.notifications')
            ->with('success', 'Email обновлен');
    }

    public function toggleStatus(NotificationEmail $notificationEmail)
    {
        Gate::forUser(auth('admin')->user())->authorize('admin');

        $notificationEmail->update([
            'is_active' => !$notificationEmail->is_active,
        ]);

        $status = $notificationEmail->is_active ? 'активирован' : 'деактивирован';

        return back()->with('success', "Email {$notificationEmail->email} {$status}");
    }

    public function destroy(NotificationEmail $notificationEmail)
    {
        Gate::forUser(auth('admin')->user())->authorize('admin');

        $email = $notificationEmail->email;
        $notificationEmail->delete();

        return redirect()
            ->route('admin.settings.notifications')
            ->with('success', "Email {$email} удален");
    }
}
