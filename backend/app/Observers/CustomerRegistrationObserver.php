<?php

namespace App\Observers;

use App\Models\CustomerRegistration;
use App\Models\User;
use App\Notifications\NewCustomerRegistration;

class CustomerRegistrationObserver
{
    public function created(CustomerRegistration $customerRegistration): void
    {
        User::where('status', 'active')
            ->whereHas('role', function ($query) {
                $query->where('name', '!=', 'student');
            })
            ->get()
            ->each(function ($user) use ($customerRegistration) {
                $user->notify(new NewCustomerRegistration($customerRegistration));
            });
    }

    public function updated(CustomerRegistration $customerRegistration): void
    {
        //
    }

    public function deleted(CustomerRegistration $customerRegistration): void
    {
        //
    }

    public function restored(CustomerRegistration $customerRegistration): void
    {
        //
    }

    public function forceDeleted(CustomerRegistration $customerRegistration): void
    {
        //
    }
}
