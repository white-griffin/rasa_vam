<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait Purchaseable
{
    /**
     * اجرای منطق پس از تکمیل خرید.
     */
    public function purchaseCompleted(): void
    {

        DB::transaction(function () {
            // منطق مختص هر مدل در اینجا اجرا می‌شود.
            $this->handlePurchaseCompletion();
        });
    }

    /**
     * متد انتزاعی که باید توسط مدل‌های پیاده‌کننده پیاده‌سازی شود.
     */
    abstract protected function handlePurchaseCompletion(): void;

}
