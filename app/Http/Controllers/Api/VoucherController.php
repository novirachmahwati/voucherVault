<?php

namespace App\Http\Controllers\Api;

use App\Models\Voucher;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use App\Http\Controllers\Controller;

class VoucherController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/vouchers",
     *     summary="Get list of vouchers",
     *     @OA\Parameter(
     *         name="kategori",
     *         in="query",
     *         description="Kategori vouchers",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of vouchers",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Voucher"))
     *     ),
     *     security={{"bearer_token":{}}},
     * )
     */
    public function index(Request $request)
    {
        $query = Voucher::query();

        if ($request->has('kategori')) {
            $query->where('kategori', $request->input('kategori'));
        }

        $vouchers = $query->get();
        
        return response()->json([
            'success' => true,
            'data' => $vouchers
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/vouchers",
     *     summary="Create a new voucher",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Voucher")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Voucher created",
     *         @OA\JsonContent(ref="#/components/schemas/Voucher")
     *     ),
     *     security={{"bearer_token":{}}},
     * )
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'kategori' => 'required',
            'status' => 'required|boolean',
        ]);

        $voucher = Voucher::create($request->all());
        return response()->json($voucher, 201);

        // Handle the image upload
        if ($request->hasFile('foto')) {
            $imagePath = $request->file('foto')->store('vouchers', 'public');
        }

        // Create the voucher
        $voucher = Voucher::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'value' => $validatedData['value'],
            'image' => $imagePath ?? null,
        ]);

        return response()->json([
            'success' => true,
            'data' => $voucher
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/vouchers/{id}",
     *     summary="Get a specific voucher",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Voucher ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Voucher details",
     *         @OA\JsonContent(ref="#/components/schemas/Voucher")
     *     ),
     *     security={{"bearer_token":{}}},
     * )
     */
    public function show(Voucher $voucher)
    {
        return $voucher;
    }

    /**
     * @OA\Put(
     *     path="/api/vouchers/{id}",
     *     summary="Update a voucher",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Voucher ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Voucher")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Voucher updated",
     *         @OA\JsonContent(ref="#/components/schemas/Voucher")
     *     ),
     *     security={{"bearer_token":{}}},
     * )
     */
    public function update(Request $request, Voucher $voucher)
    {
        $request->validate([
            'nama' => 'sometimes|required',
            'foto' => 'nullable|string',
            'kategori' => 'sometimes|required',
            'status' => 'sometimes|required|boolean',
        ]);

        $voucher->update($request->all());
        return response()->json($voucher, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/vouchers/{id}",
     *     summary="Delete a voucher",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Voucher ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Voucher deleted"
     *     ),
     *     security={{"bearer_token":{}}},
     * )
     */
    public function destroy(Voucher $voucher)
    {
        $voucher->delete();
        return response()->json(null, 204);
    }

    /**
     * @OA\Post(
     *     path="/api/vouchers/restore/{id}",
     *     summary="Restore a voucher",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Voucher ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Voucher restored"
     *     ),
     *     security={{"bearer_token":{}}},
     * )
     */
    public function restore($id)
    {
        // Find the voucher in the trashed state
        $voucher = Voucher::onlyTrashed()->find($id);

        if ($voucher) {
            $voucher->restore();
            return response()->json([
                'success' => true,
                'message' => 'Voucher restored successfully.'
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Voucher not found or not deleted.'
        ], 404);
    }
}
