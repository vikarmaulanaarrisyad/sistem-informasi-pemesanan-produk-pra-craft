<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeUser($query)
    {
        return $query->where('user_id', auth()->id());
    }


    public function statusColor()
    {
        $color = '';

        switch ($this->status) {
            case 'success':
                $color = 'success';
                break;
            case 'deny':
                $color = 'danger';
                break;
            case 'pending':
                $color = 'warning';
                break;
            case 'cancel':
                $color = 'dark';
                break;
            default:
                break;
        }

        return $color;
    }
    public function statusText()
    {
        $text = '';

        switch ($this->status) {
            case 'success':
                $text = 'Dikonfirmasi';
                break;
            case 'deny':
                $text = 'Ditolak';
                break;
            case 'pending':
                $text = 'Menunggu';
                break;
            case 'cancel':
                $text = 'Dibatalkan';
                break;
            default:
                break;
        }

        return $text;
    }
}
