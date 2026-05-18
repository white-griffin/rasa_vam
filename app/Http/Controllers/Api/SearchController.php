<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Search\MultiModelSearchService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    protected $searchService;

    public function __construct(MultiModelSearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:2',
            'per_page' => 'nullable|integer|min:1|max:100',
        ]);

        $query = $request->input('q');
        $perPage = $request->input('per_page', 10);

        $results = $this->searchService->search($query, $perPage);

        return response()->json([
            'success' => true,
            'query' => $query,
            'results' => $results,
        ]);
    }

    public function searchPaginated(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:2',
            'per_page' => 'nullable|integer|min:1|max:100',
            'page' => 'nullable|integer|min:1',
        ]);

        $query = $request->input('q');
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);

        $results = $this->searchService->searchPaginated($query, $perPage, $page);

        return response()->json([
            'success' => true,
            'query' => $query,
            'results' => $results,
        ]);
    }

    public function searchWithLimit(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:2',
            'bank_services_limit' => 'nullable|integer|min:1|max:50',
            'blogs_limit' => 'nullable|integer|min:1|max:50',
        ]);

        $query = $request->input('q');
        $bankServicesLimit = $request->input('bank_services_limit', 5);
        $blogsLimit = $request->input('blogs_limit', 5);

        $results = $this->searchService->searchWithLimit($query, $bankServicesLimit, $blogsLimit);

        return response()->json([
            'success' => true,
            'query' => $query,
            'results' => $results,
        ]);
    }
}
