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

    public function statusColor()
    {
        $color = '';

        switch ($this->status) {
            case 'confirmed':
                $color = 'success';
                break;
            case 'not confirmed':
                $color = 'dark';
                break;
            case 'pending':
                $color = 'warning';
                break;
            case 'canceled':
                $color = 'danger';
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
            case 'confirmed':
                $text = 'Dikonfirmasi';
                break;
            case 'not confirmed':
                $text = 'Tidak Dikonfirmasi';
                break;
            case 'pending':
                $text = 'Menunggu';
                break;
            case 'canceled':
                $text = 'Dibatalkan';
                break;
            default:
                break;
        }

        return $text;
    }
}
