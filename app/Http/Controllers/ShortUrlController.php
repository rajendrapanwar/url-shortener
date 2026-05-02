<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShortUrlController extends Controller
{

    public function create()
    {
        return view('short-urls.create');
    }


    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'original_url' => 'required|url',
        ]);

        $shortUrl = ShortUrl::create([
            'user_id' => $user->id,
            'company_id' => $user->company_id,
            'original_url' => $request->original_url,
            'short_code' => $this->generateUniqueCode(),
        ]);

        return redirect()->route('short-urls.index')
            ->with('success', 'Short URL created: ' . url($shortUrl->short_code));
    }

    public function index()
    {
        $user = auth()->user();

        if ($user->isSuperAdmin()) {
            $shortUrls = ShortUrl::with('user', 'company')->latest()->get();
        } elseif ($user->isAdmin()) {
            $shortUrls = ShortUrl::where('company_id', $user->company_id)
                ->with('user')
                ->latest()
                ->get();
        } else {
            $shortUrls = ShortUrl::where('user_id', $user->id)
                ->latest()
                ->get();
        }

        return view('short-urls.index', compact('shortUrls'));
    }

    public function redirect($code)
    {
        $shortUrl = ShortUrl::where('short_code', $code)->firstOrFail();

        return redirect()->away($shortUrl->original_url);
    }


    private function generateUniqueCode(): string
    {
        do {
            $code = Str::random(6);
        } while (ShortUrl::where('short_code', $code)->exists());

        return $code;
    }
}
