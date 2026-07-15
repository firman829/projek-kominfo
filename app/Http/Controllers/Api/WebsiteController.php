<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWebsiteRequest;
use App\Http\Requests\UpdateWebsiteRequest;
use App\Http\Resources\WebsiteResource;
use App\Models\Website;
use App\Services\ApiResponseService;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    /**
     * Menampilkan semua website milik user yang login.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Website::class);

        $websites = Website::with('user')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return ApiResponseService::success(
            'Daftar website berhasil diambil.',
            WebsiteResource::collection($websites)
        );
    }

    /**
     * Menambahkan website baru.
     */
    public function store(StoreWebsiteRequest $request)
    {
        $this->authorize('create', Website::class);

        $website = Website::create([
            'user_id'     => $request->user()->id,
            'name'        => $request->name,
            'institution' => $request->institution,
            'url'         => $request->url,
            'domain'      => $request->domain,
            'province'    => $request->province,
            'city'        => $request->city,
            'status'      => $request->status,
            'description' => $request->description,
        ]);

        return ApiResponseService::success(
            'Website berhasil ditambahkan.',
            new WebsiteResource($website->load('user')),
            201
        );
    }

    /**
     * Menampilkan detail website.
     */
    public function show(Website $website)
    {
        $this->authorize('view', $website);

        $website->load('user');

        return ApiResponseService::success(
            'Detail website berhasil diambil.',
            new WebsiteResource($website)
        );
    }

    /**
     * Mengubah data website.
     */
    public function update(UpdateWebsiteRequest $request, Website $website)
    {
        $this->authorize('update', $website);

        $website->update([
            'name'        => $request->name,
            'institution' => $request->institution,
            'url'         => $request->url,
            'domain'      => $request->domain,
            'province'    => $request->province,
            'city'        => $request->city,
            'status'      => $request->status,
            'description' => $request->description,
        ]);

        return ApiResponseService::success(
            'Website berhasil diperbarui.',
            new WebsiteResource(
                $website->fresh()->load('user')
            )
        );
    }

    /**
     * Menghapus website.
     */
    public function destroy(Website $website)
    {
        $this->authorize('delete', $website);

        $website->delete();

        return ApiResponseService::success(
            'Website berhasil dihapus.'
        );
    }
}