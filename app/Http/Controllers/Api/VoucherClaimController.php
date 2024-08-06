<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VoucherClaim;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use Carbon\Carbon;

class VoucherClaimController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/voucher_claims",
     *     summary="Get list of voucher claims",
     *     @OA\Response(
     *         response=200,
     *         description="List of voucher claims",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/VoucherClaim"))
     *     ),
     *     security={{"bearer_token":{}}},
     * )
     */
    public function index()
    {
        $voucherClaims = VoucherClaim::with(['voucher' => function ($query) {
            $query->withTrashed();
        }])->get();
        
        return response()->json([
            'success' => true,
            'data' => $voucherClaims
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/voucher_claims",
     *     summary="Create a new voucher claim",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/VoucherClaim")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Voucher claim created",
     *         @OA\JsonContent(ref="#/components/schemas/VoucherClaim")
     *     ),
     *     security={{"bearer_token":{}}},
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_voucher' => 'required|exists:vouchers,id',
        ]);
        
        $validated['tanggal_claim'] = Carbon::now();

        $voucherClaim = VoucherClaim::create($validated);
        return response()->json([
            'success' => true,
            'message' => 'Voucher claimed successfully!'
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/voucher_claims/{id}",
     *     summary="Get a specific voucher claim",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Voucher Claim ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Voucher claim details",
     *         @OA\JsonContent(ref="#/components/schemas/VoucherClaim")
     *     ),
     *     security={{"bearer_token":{}}},
     * )
     */
    public function show(VoucherClaim $voucherClaim)
    {
        return $voucherClaim;
    }

    /**
     * @OA\Put(
     *     path="/api/voucher_claims/{id}",
     *     summary="Update a voucher claim",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Voucher Claim ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/VoucherClaim")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Voucher claim updated",
     *         @OA\JsonContent(ref="#/components/schemas/VoucherClaim")
     *     ),
     *     security={{"bearer_token":{}}},
     * )
     */
    public function update(Request $request, VoucherClaim $voucherClaim)
    {
        $request->validate([
            'id_voucher' => 'sometimes|required|exists:vouchers,id',
            'tanggal_claim' => 'sometimes|required|date',
        ]);

        $voucherClaim->update($request->all());
        return response()->json($voucherClaim, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/voucher_claims/{id}",
     *     summary="Delete a voucher claim",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Voucher Claim ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Voucher claim deleted"
     *     ),
     *     security={{"bearer_token":{}}},
     * )
     */
    public function destroy($id)
    {
        $voucherClaim = VoucherClaim::find($id);

        if ($voucherClaim) {
            $voucherId = $voucherClaim->id_voucher;
            $voucherClaim->delete();

            return response()->json(['success' => true, 'voucherId' => $voucherId]);
        }

        return response()->json(['success' => false], 404);
    }
}
