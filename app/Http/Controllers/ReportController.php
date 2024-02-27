<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Response;
use App\Http\Resources\ReportResource;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = Report::query()
            ->paginate();

        return ReportResource::collection(
            $reports
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReportRequest $request)
    {
        $report = Report::create(
            $request->validated()
        );

        return ReportResource::make(
            $report->load(['user'])
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        return ReportResource::make(
            $report->load(['user'])
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReportRequest $request, Report $report)
    {
        abort_unless(auth()->user()->tokenCan('report.update'),
            Response::HTTP_FORBIDDEN
        );
        $this->authorize('update', $report);

        $report->update(
            $request->validated()
        );

        return ReportResource::make(
            $report->load(['user'])
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        abort_unless(auth()->user()->tokenCan('report.delete'),
            Response::HTTP_FORBIDDEN
        );
        $this->authorize('delete', $report);

        $report->delete();
    }
}
