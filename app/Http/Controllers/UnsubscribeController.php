<?php

namespace App\Http\Controllers;

use App\Models\EmailSubscriber;
use Illuminate\Http\Request;

class UnsubscribeController extends Controller
{
    public function show(string $token)
    {
        $subscriber = EmailSubscriber::where('unsubscribe_token', $token)->first();

        return view('unsubscribe', [
            'subscriber' => $subscriber,
            'done'       => $subscriber && $subscriber->unsubscribed_at !== null,
            'notFound'   => $subscriber === null,
        ]);
    }

    public function confirm(Request $request, string $token)
    {
        $subscriber = EmailSubscriber::where('unsubscribe_token', $token)->first();

        if ($subscriber && ! $subscriber->unsubscribed_at) {
            $subscriber->update([
                'unsubscribed_at' => now(),
                'unsubscribed_ip' => $request->ip(),
            ]);
        }

        return view('unsubscribe', [
            'subscriber' => $subscriber,
            'done'       => true,
            'notFound'   => $subscriber === null,
        ]);
    }
}
