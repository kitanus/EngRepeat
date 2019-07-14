<?php

namespace App\Http\Middleware;

use App\Models\Dictionary;
use Closure;

class CheckRepeat
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        foreach (Dictionary::all() as $id => $dictionary)
        {
            foreach ($request->word as $key => $word)
            {
                if(
                    mb_strtoupper($dictionary->word) == mb_strtoupper($word) ||
                    mb_strtoupper($dictionary->translate) == mb_strtoupper($word) ||
                    mb_strtoupper($dictionary->translate) == mb_strtoupper($request->translate[$key]) ||
                    mb_strtoupper($dictionary->word) == mb_strtoupper($request->translate[$key])
                )
                {
                    return redirect('dictionary');
                }
            }
        }

        return $next($request);
    }
}
