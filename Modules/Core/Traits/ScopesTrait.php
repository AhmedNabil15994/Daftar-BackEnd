<?php

namespace Modules\Core\Traits;

trait ScopesTrait
{
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeUnActive($query)
    {
        return $query->where('status', false);
    }

    public function scopeIsTrused($query)
    {
        return $query->where('is_trusted', true);
    }

    public function scopeOnlyDeleted($query)
    {
        return $query->onlyTrashed();
    }

    public function scopeWithDeleted($query)
    {
        return $query->withTrashed();
    }

    public function scopeNotDeleted($query)
    {
        return $query->where('deleted_at', null);
    }

    public function scopeMainCategories($query)
    {
        return $query->where('category_id', '=', null);
    }

    public function scopeUnexpired($query)
    {
        return $query->where('end_at', '>', date('Y-m-d'));
    }

    public function scopeExpired($query)
    {
        return $query->where('end_at', '<', date('Y-m-d'));
    }

    public function scopeStarted($query)
    {
        return $query->where('start_at', '<=', date('Y-m-d'));
    }

    public function scopeSuccessOrderStatus($query)
    {
        return $query->where('success_status', 1);
    }

    public function scopeFailedOrderStatus($query)
    {
        return $query->where('failed_status', 1);
    }
}
