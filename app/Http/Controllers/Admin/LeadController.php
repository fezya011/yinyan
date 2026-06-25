<?php
// app/Http/Controllers/Admin/LeadController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Lead\UpdateLeadStatusRequest;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        Gate::forUser(auth('admin')->user())->authorize('manage-leads');

        $leads = Lead::with('product')
            ->when($request->filled('status'), function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('phone', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%");
            })
            ->when($request->filled('date_from'), function ($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->date_from);
            })
            ->when($request->filled('date_to'), function ($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->date_to);
            })
            ->latest()
            ->paginate(20);

        $statuses = Lead::getStatuses();
        $statusCounts = Lead::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return view('admin.leads.index', compact('leads', 'statuses', 'statusCounts'));
    }

    public function show(Lead $lead)
    {
        Gate::forUser(auth('admin')->user())->authorize('manage-leads');

        $lead->load('product');
        $statuses = Lead::getStatuses();

        return view('admin.leads.show', compact('lead', 'statuses'));
    }

    public function updateStatus(UpdateLeadStatusRequest $request, Lead $lead)
    {
        Gate::forUser(auth('admin')->user())->authorize('manage-leads');

        $lead->changeStatus($request->status);

        return back()->with('success', 'Статус заявки обновлен');
    }

    public function destroy(Lead $lead)
    {
        Gate::forUser(auth('admin')->user())->authorize('manage-leads');

        $lead->delete();

        return redirect()
            ->route('admin.leads.index')
            ->with('success', 'Заявка успешно удалена');
    }

    public function export(Request $request)
    {
        Gate::forUser(auth('admin')->user())->authorize('manage-leads');

        $leads = Lead::query()
            ->when($request->filled('status'), function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->when($request->filled('date_from'), function ($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->date_from);
            })
            ->when($request->filled('date_to'), function ($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->date_to);
            })
            ->get();

        $filename = 'leads_' . date('Y-m-d') . '.csv';
        $handle = fopen('php://temp', 'w');

        fputcsv($handle, [
            'ID',
            'Имя',
            'Телефон',
            'Email',
            'Сообщение',
            'Товар',
            'Бюджет',
            'Город',
            'Статус',
            'Дата создания'
        ]);

        foreach ($leads as $lead) {
            fputcsv($handle, [
                $lead->id,
                $lead->name,
                $lead->phone,
                $lead->email,
                $lead->message,
                $lead->product?->name ?? 'Не указан',
                $lead->estimated_budget ?? 'Не указан',
                $lead->delivery_city ?? 'Не указан',
                Lead::getStatuses()[$lead->status] ?? $lead->status,
                $lead->created_at->format('d.m.Y H:i'),
            ]);
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }
}
