<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Todo",
 *     required={"title", "status"},
 *     @OA\Property(property="id", type="integer", format="int64"),
 *     @OA\Property(property="title", type="string", maxLength=255),
 *     @OA\Property(property="details", type="string", nullable=true),
 *     @OA\Property(property="status", type="string", enum={"completed", "in-progress", "not-started"}),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 * 
 * @OA\Schema(
 *     schema="TodoRequest",
 *     required={"title", "status"},
 *     @OA\Property(property="title", type="string", maxLength=255),
 *     @OA\Property(property="details", type="string", nullable=true),
 *     @OA\Property(property="status", type="string", enum={"completed", "in-progress", "not-started"})
 * )
 */
class Todo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'details',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
