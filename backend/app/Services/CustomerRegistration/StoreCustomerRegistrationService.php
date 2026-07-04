<?php

namespace App\Services\CustomerRegistration;

use App\Models\CustomerRegistration;

class StoreCustomerRegistrationService
{
    public function run(array $data): CustomerRegistration
    {
        return CustomerRegistration::create($data);
    }
}
