<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Website;

class WebsitePolicy
{
    /**
     * Melihat daftar website.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Melihat detail website.
     */
    public function view(User $user, Website $website): bool
    {
        return $user->id === $website->user_id;
    }

    /**
     * Membuat website baru.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Mengubah website.
     */
    public function update(User $user, Website $website): bool
    {
        return $user->id === $website->user_id;
    }

    /**
     * Menghapus website.
     */
    public function delete(User $user, Website $website): bool
    {
        return $user->id === $website->user_id;
    }

    /**
     * Restore website.
     */
    public function restore(User $user, Website $website): bool
    {
        return $user->id === $website->user_id;
    }

    /**
     * Force Delete website.
     */
    public function forceDelete(User $user, Website $website): bool
    {
        return $user->id === $website->user_id;
    }
}