<?php

namespace App\Http\Controllers\Api;

/**
 * @OA\Info(
 *     title="API Documentation",
 *     version="1.0.0",
 *     description="This is the API documentation for our application.",
 *     @OA\Contact(
 *         email="support@example.com"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 * @OA\SecurityScheme(
 *     type="http",
 *     description="Authentication Bearer Token",
 *     name="Authentication Bearer Token",
 *     in="header",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="bearer_token",
 * )
 */

class OpenApiSpec
{
}
