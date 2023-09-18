<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LogApiRequests
{
    public function handle($request, Closure $next)
    {
        // Log the API request details
        $user = auth()->user();

        Log::info('API Request:', [
            'user_id' => $user ? $user->id : null,
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'input' => $request->all(),
        ]);

        // Continue processing the request and get the response
        $response = $next($request);

        // Log the API response
        Log::info('API Response:', [
            'user_id' => $user ? $user->id : null,
            'status_code' => $response->status(),
            'content' => $this->getResponseContent($response),
        ]);

        // Convert request data and response content to JSON strings
        $requestData = json_encode($request->all());
        $responseContent = json_encode($this->getResponseContent($response));

        // Log details to the database
        DB::table('api_logs')->insert([
            'user_id' => $user ? $user->id : null,
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'request_data' => $requestData,
            'status_code' => $response->status(),
            'response_content' => $responseContent,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $response;
    }

    private function getResponseContent($response)
    {
        // Check if the response has JSON content
        if (Str::contains($response->headers->get('Content-Type'), 'json')) {
            return json_decode($response->content(), true);
        }

        // If not JSON, return the raw content
        return $response->content();
    }
}
