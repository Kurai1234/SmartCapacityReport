<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AccessPoint;
class AccessPointStatistic extends Model
{
    use HasFactory;
    protected $table='access_point_statistics';
    protected $fillable = [
            // 'access_point_id',
            // 'mode',
            // 'dl_retransmit',
            // 'dl_retransmit_pcts',
            // 'dl_pkts',
            // 'ul_pkts',
            // 'dl_throughput',
            // 'ul_throughput',
            // 'status',
            // 'connected_sms',
            // 'reboot',
            // 'frame_utilization',
        
    ];
    public function accesspoint(){
        return $this->belongsTo(AccessPoint::class,'access_point_id');
    }
    
}
