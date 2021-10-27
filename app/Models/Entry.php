<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entry extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        "name",
        "phone_number",
        "car_number",
        "token"
    ];
    public function scopeGetCalculatedData($query, $id)
    {
        return $query->where(["id" => $id])->first();
    }
    public function scopeGetIncome($query, $from_date = null, $to_date = null)
    {
        if ($from_date && $to_date) {
            $query->whereBetween('created_at', [$from_date, $to_date]);
        }
        return $query->sum("bill");
    }
    public function scopeGetIncomeToday($query)
    {
        return  $query->whereDate('created_at', \Carbon\Carbon::today("Asia/Dhaka"))->sum("bill");
    }
    public function scopeGetEntry($query, $from_date = null, $to_date = null)
    {
        if ($from_date && $to_date) {
            $query->whereBetween('created_at', [$from_date, $to_date]);
        }
        return $query->count();
    }
}
