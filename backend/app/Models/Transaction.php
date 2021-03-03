<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model 
{
    // defenisi tabel yg digunakan di database
    protected $table = 'transactions';

    // yang dengan mudah di isi/ di lihat dari kolom kolom tabel
    protected $fillable = [
        'campaign_id',
        'user_id',
        'bank',
        'no_transaction',
        'type',
        'nominal',
        'unique_code',
        'total_nominal',
        'no_rek_origin',
        'no_rek_destination',
        'updated_by',
        'created_by',
    ];

    // yang gak akan ditampilkan atribut nya diluar dari lingkungan lumen/laravel
    protected $hidden = [
        // 'password',
    ];


    /**
     * relasi yang digunakan misal:
     * campaign berelasi (punya id_campaign) pada tabel campaign member
     * berarti yang punya adalah si campaign, dan campaign members belongsTo si campaign
     */
    public function campaigns()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }

}