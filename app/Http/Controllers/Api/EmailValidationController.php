<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidateEmailRequest;
use App\Models\EmailCheck;
use App\Services\EmailValidationService;

class EmailValidationController extends Controller
{
    public function __construct(private EmailValidationService $service) {}

    public function __invoke(ValidateEmailRequest $request)
    {
        $email = $request->string('email');

        $result = $this->service->validate($email);
        
        \Log::info($result);

        $record = EmailCheck::create([
            'email'    => $email,
            'is_valid' => $result['is_valid'],
            'reason'   => $result['reason'] ?? 'unknown',
            'meta'     => json_encode($result['meta'] ?? []),
        ]);

        return response()->json([
            'id'       => $record->id,
            'email'    => $record->email,
            'is_valid' => $record->is_valid,
            'reason'   => $record->reason,
            'meta'     => $result['meta'] ?? null,
            'checked_at' => $record->created_at,
        ]);
    }
}
