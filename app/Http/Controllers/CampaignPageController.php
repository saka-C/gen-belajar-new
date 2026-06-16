<?php

namespace App\Http\Controllers;

use App\Models\Campaign;

class CampaignPageController extends Controller
{
    public function home()
    {
        $donorsCount = [
            'donations as donors_count' => fn ($query) => $query->where('payment_status', 'success'),
        ];

        $collectedAmount = [
            'donations as collected_amount' => fn ($query) => $query->where('payment_status', 'success'),
        ];

        $pinnedCampaign = Campaign::query()
            ->withCount($donorsCount)
            ->withSum($collectedAmount, 'amount')
            ->where('status', 'active')
            ->where('is_pinned', true)
            ->first();

        $activeCampaigns = Campaign::query()
            ->withCount($donorsCount)
            ->withSum($collectedAmount, 'amount')
            ->where('status', 'active')
            ->where('is_pinned', false)
            ->orderBy('campaign_id', 'desc')
            ->get();

        return view('index', compact('pinnedCampaign', 'activeCampaigns'));
    }

    public function index()
    {
        $donorsCount = [
            'donations as donors_count' => fn ($query) => $query->where('payment_status', 'success'),
        ];

        $collectedAmount = [
            'donations as collected_amount' => fn ($query) => $query->where('payment_status', 'success'),
        ];

        $activeCampaigns = Campaign::query()
            ->withCount($donorsCount)
            ->withSum($collectedAmount, 'amount')
            ->where('status', 'active')
            ->orderBy('campaign_id', 'desc')
            ->get();

        $completedCampaigns = Campaign::query()
            ->withCount($donorsCount)
            ->withSum($collectedAmount, 'amount')
            ->whereIn('status', ['completed', 'complete'])
            ->orderBy('campaign_id', 'desc')
            ->get();

        return view('pages.program', compact('activeCampaigns', 'completedCampaigns'));
    }

    public function show(int $campaign)
    {
        $campaign = Campaign::query()
            ->with([
                'donations' => fn ($query) => $query
                    ->where('payment_status', 'success')
                    ->orderBy('donation_id', 'desc')
                    ->limit(10),
                'donations.user',
            ])
            ->withCount([
                'donations as donors_count' => fn ($query) => $query->where('payment_status', 'success'),
            ])
            ->withSum([
                'donations as collected_amount' => fn ($query) => $query->where('payment_status', 'success'),
            ], 'amount')
            ->where('campaign_id', $campaign)
            ->whereIn('status', ['active', 'completed', 'complete'])
            ->firstOrFail();

        return view('pages.detail-donation', compact('campaign'));
    }
}