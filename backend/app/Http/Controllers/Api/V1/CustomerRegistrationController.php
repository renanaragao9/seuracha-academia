<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Api\V1\CustomerRegistration\StoreCustomerRegistrationRequest;
use App\Services\CustomerRegistration\StoreCustomerRegistrationService;
use Illuminate\Http\JsonResponse;

class CustomerRegistrationController extends BaseController
{
    public function store(
        StoreCustomerRegistrationRequest $storeCustomerRegistrationRequest,
        StoreCustomerRegistrationService $storeCustomerRegistrationService
    ): JsonResponse {
        $data = $storeCustomerRegistrationRequest->validated();
        $customerRegistration = $storeCustomerRegistrationService->run($data);

        if (! $customerRegistration) {
            return $this->errorResponse(
                errors: ['customer_registration' => 'Não foi possível criar o pré cadastro.'],
                message: 'Não foi possível criar o pré cadastro.',
                statusCode: 404
            );
        }

        return $this->successResponse(
            data: null,
            message: 'Pré cadastro criado com sucesso.',
        );
    }
}
