<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     schema="Voucher",
 *     type="object",
 *     required={"nama", "kategori", "status"},
 *     @OA\Property(property="nama", type="string"),
 *     @OA\Property(property="foto", type="string"),
 *     @OA\Property(property="kategori", type="string"),
 *     @OA\Property(property="status", type="boolean"),
 * )
 */
class Voucher extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama',
        'foto',
        'kategori',
        'status',
    ];

    public function voucherClaims()
    {
        return $this->hasMany(VoucherClaim::class, 'id_voucher');
    }
}
