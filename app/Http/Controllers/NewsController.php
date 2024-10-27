<?php

namespace App\Http\Controllers;

use App\Http\Requests\News\FilterRequest;
use App\Models\Currency;
use App\Models\News;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class NewsController extends Controller
{
    public function __invoke(FilterRequest $request): View|Factory
    {
        $cacheKey = 'news';
        if ($request->validated('start_date')) {
            $cacheKey .= ('|start_date:' . $request->validated('start_date'));
        }
        if ($request->validated('end_date')) {
            $cacheKey .= ('|end_date:' . $request->validated('end_date'));
        }
        if ($request->validated('currency')) {
            $cacheKey .= ('|currency:' . $request->validated('currency'));
        }
        if ($request->validated('page')) {
            $cacheKey .= ('|page:' . $request->validated('page'));
        }

        $currencies = Cache::remember('currencies', 60 * 60, function () {
            return Currency::all();
        });

        $news = Cache::remember($cacheKey, 60 * 60, function () use ($request) {
            return News::with('currencies')
                ->when($request->validated('currency'), function (Builder $query) use ($request) {
                    return $query->whereHas('currencies', function (Builder $query) use ($request) {
                        return $query->where('currency_id', $request->validated('currency'));
                    });
                })
                ->when($request->validated('start_date'), function (Builder $query) use ($request) {
                    return $query->where('published_at', '>=', Carbon::parse($request->validated('start_date'))->format('Y-m-d 00:00:00'));
                })
                ->when($request->validated('end_date'), function (Builder $query) use ($request) {
                    return $query->where('published_at', '<=', Carbon::parse($request->validated('end_date'))->format('Y-m-d 23:59:59'));
                })
                ->paginate(20);
        });
        return view('welcome', compact('currencies', 'news'));
    }
}
