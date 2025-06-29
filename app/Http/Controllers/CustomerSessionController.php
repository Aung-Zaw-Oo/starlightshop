<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerSession;

class CustomerSessionController extends Controller
{
    public function storeOrUpdateSession(Request $request, $customerId)
    {
        $userAgent = $request->header('User-Agent');
        $browser = $this->detectBrowser($userAgent);
        $device = $this->detectDevice($userAgent);

        $session = CustomerSession::where('customer_id', $customerId)
            ->where('browser', $browser)
            ->where('device', $device)
            ->first();

        if ($session) {
            $session->visit_count += 1;
            $session->percentage = $this->calculatePercentage($customerId, $session->visit_count);
            $session->save();
        } else {
            CustomerSession::create([
                'customer_id' => $customerId,
                'browser' => $browser,
                'device' => $device,
                'visit_count' => 1,
                'percentage' => 0,
                'status' => 'active'
            ]);
        }
    }

    private function detectBrowser($userAgent)
    {
        if (strpos($userAgent, 'Chrome') !== false) {
            return 'Chrome';
        } elseif (strpos($userAgent, 'Firefox') !== false) {
            return 'Firefox';
        } elseif (strpos($userAgent, 'Safari') !== false) {
            return 'Safari';
        }
        return 'Unknown';
    }

    private function detectDevice($userAgent)
    {
        if (preg_match('/Mobile|Android|iPhone|iPad/', $userAgent)) {
            return 'Mobile';
        }
        return 'Desktop';
    }

    private function calculatePercentage($customerId, $currentVisitCount)
    {
        $totalVisits = CustomerSession::where('customer_id', $customerId)->sum('visit_count');

        if ($totalVisits == 0) {
            return 0;
        }

        return round(($currentVisitCount / $totalVisits) * 100, 2);
    }
}
