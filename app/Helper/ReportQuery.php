<?php

use Illuminate\Support\Facades\DB;

/**
 * Class ReportQuery.
 * Peak Throughput from a datetime range
 * @package Illuminate\Support\Facades\DB
 *
 */
class ReportQuery
{
    /**
     * @param array $array accepts 2 Datetime Element in a  Array
     * @return object
     */
    public static function perform(array $array)
    {
        $array = array_merge($array, $array);
        $sql = "
        SELECT  z.id, z.connected_sms, z.created_at, y.*,z.dl_capacity_throughput
        FROM access_point_statistics z
        USE INDEX(access_point_statistics_created_at_index)
        INNER JOIN
            (
                SELECT y.name, y.mac_address, y.product, x.access_point_id, x.peak
                FROM access_points AS y
                INNER JOIN
                    (
                        SELECT x.access_point_id, MAX(x.dl_throughput) AS peak
                        FROM access_point_statistics AS x
                        USE INDEX(access_point_statistics_created_at_index)
                        WHERE x.created_at >= :start AND x.created_at <= :end
                        GROUP BY x.access_point_id
                    )x  on (x.access_point_id = y.id)
            )y on y.access_point_id = z.access_point_id AND y.peak = z.dl_throughput
            WHERE z.created_at >= :start2 AND z.created_at <= :end2
            ORDER BY y.name
            ";
        $result =   DB::select(DB::raw($sql), $array);
        $temp = array_unique(array_column($result, 'access_point_id'));
        return array_intersect_key($result, $temp);
    }
}
