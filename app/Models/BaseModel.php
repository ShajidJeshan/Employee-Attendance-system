<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BaseModel extends Model
{
    function getLast($table_name, $column_name)
    {
        return DB::table($table_name)->latest($column_name)->first();
    }

    function getColumnValue($table_name, $column_name)
    {
        return DB::table($table_name)->select($column_name)->get();
    }

    function getAllInfo($table_name)
    {
        return DB::table($table_name)->get();
    }

    function getAllInfoOrderBy($table_name, $orderBy)
    {
        return DB::table($table_name)->orderBy($orderBy)->get();
    }

    function getAllInfoByArray($table_name, $column_with_value_array)
    {
        return DB::table($table_name)->where($column_with_value_array)->get();
    }

    function getAllInfoByArrayOrderBy($table_name, $column_with_value_array , $orderBy)
    {
        return DB::table($table_name)->where($column_with_value_array)->orderBy($orderBy)->get();
    }

    function getAllInfoByArrayGroupBy($table_name, $group_columns, $column_with_value_array)
    {
        return DB::table($table_name)->groupBy($group_columns)->having($column_with_value_array)->get();
    }

    function getWhereJoin($table_name, $join_table, $join_condition, $column_with_value_array)
    {
//        dd($join_table);
        return DB::table($table_name)
            ->join($join_table, function ($join) use ($column_with_value_array, $join_condition) {
                $join->on($join_condition);
            })
            ->where($column_with_value_array)->get();
    }

    function getWhereJoinOrderBy($table_name, $join_table, $join_condition, $column_with_value_array, $orderBy)
    {
//        dd($join_table);
        return DB::table($table_name)
            ->join($join_table, function ($join) use ($column_with_value_array, $join_condition) {
                $join->on($join_condition);
            })
            ->where($column_with_value_array)->orderBy($orderBy)->get();
    }


    function updateWhere($table_name, $where_column_with_value_array, $update_column_with_value_array)
    {
        $var = DB::table($table_name)->where($where_column_with_value_array)->update($update_column_with_value_array);
        return $var;
    }

    function insert($table_name, $insert_array)
    {
        DB::table($table_name)->insert($insert_array);
        return true;
    }

    function updateOrInsert($table_name, $where_array, $insertOrUpdate)
    {
        $var = DB::table($table_name)
            ->updateOrInsert($where_array, $insertOrUpdate);
        return $var;
    }

    function insertGetId($table_name, $insert_array)
    {
        return DB::table($table_name)->insertGetId($insert_array);
    }

    function deleteWhere($table_name, $delete_where)
    {
        DB::table($table_name)->where($delete_where)->delete();
        return true;
    }
}
