<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="VoucherClaim",
 *     type="object",
 *     required={"id_voucher", "tanggal_claim"},
 *     @OA\Property(property="id_voucher", type="string"),
 *     @OA\Property(property="tanggal_claim", type="string", format="date"),
 * )
 */
class VoucherClaim extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_voucher',
        'tanggal_claim',
    ];

    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'id_voucher');
    }
}
