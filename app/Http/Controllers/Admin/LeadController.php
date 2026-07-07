<?php
// app/Http/Controllers/Admin/LeadController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Lead\UpdateLeadStatusRequest;
use App\Models\Lead;
use App\Services\Admin\LeadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Exports\LeadsExport;
use Maatwebsite\Excel\Facades\Excel;

class LeadController extends Controller
{
    public function __construct(
        private readonly LeadService $leadService
    ) {}

    public function index(Request $request)
    {
        Gate::forUser(auth('admin')->user())->authorize('manage-leads');

        $leads = $this->leadService->getFilteredLeads($request);
        $statuses = Lead::getStatuses();
        $statusCounts = $this->leadService->getStatusCounts();

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

        $this->leadService->updateStatus($lead, $request->status);

        return redirect()
            ->route('admin.leads.show', $lead)
            ->with('success', 'Статус заявки обновлен');
    }

    public function destroy(Lead $lead)
    {
        Gate::forUser(auth('admin')->user())->authorize('manage-leads');

        $this->leadService->delete($lead);

        return redirect()
            ->route('admin.leads.index')
            ->with('success', 'Заявка успешно удалена');
    }

    public function exportPage(Request $request)
    {
        Gate::forUser(auth('admin')->user())->authorize('manage-leads');

        $statuses = Lead::getStatuses();
        $totalLeads = $this->leadService->getTotalCount();

        return view('admin.leads.export', compact('statuses', 'totalLeads'));
    }

    public function export(Request $request)
    {
        Gate::forUser(auth('admin')->user())->authorize('manage-leads');

        // Получаем параметры фильтрации
        $status = $request->input('status');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        return Excel::download(
            new LeadsExport($status, $dateFrom, $dateTo),
            'leads_' . date('Y-m-d') . '.xlsx'
        );
    }
}
