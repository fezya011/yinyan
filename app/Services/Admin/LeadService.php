<?php
// app/Services/Admin/LeadService.php

namespace App\Services\Admin;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class LeadService
{
    public function getFilteredLeads(Request $request): LengthAwarePaginator
    {
        return Lead::with('product')
            ->when($request->filled('status'), function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->search;
                $q->where(function($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('date_from'), function ($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->date_from);
            })
            ->when($request->filled('date_to'), function ($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->date_to);
            })
            ->latest()
            ->paginate(20);
    }

    public function getStatusCounts(): array
    {
        return Lead::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
    }

    public function updateStatus(Lead $lead, string $status): Lead
    {
        $lead->changeStatus($status);
        return $lead;
    }

    public function delete(Lead $lead): void
    {
        $lead->delete();
    }

    public function getTotalCount(): int
    {
        return Lead::count();
    }

    public function getLeadsForExport(Request $request): \Illuminate\Database\Eloquent\Collection
    {
        return Lead::query()
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
    }

    public function getNewLeadsCount(): int
    {
        return Lead::new()->count();
    }
}
