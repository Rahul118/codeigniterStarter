<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

function getRows($table, $whrArr = '', $orderby = '', $limit = '', $offset = 0, $joinArr = '')
{
    $CI = &get_instance();
    if ('' != $whrArr) {
        $CI->db->where($whrArr);
    }
    if ('' != $orderby) {
        $CI->db->order_by($orderby[0], $orderby[1]);
    }
    if ('' != $limit) {
        $CI->db->limit($limit, $offset);
    }
    if ('' !== $joinArr) {
        if (2 == count($joinArr)) {
            $CI->db->join($joinArr[0], $joinArr[1]);
        } else {
            $CI->db->join($joinArr[0], $joinArr[1], $joinArr[2]);
        }
    }

    return $CI->db->get($table)->result();
}
function getRow($table, $whrArr = '')
{
    $CI = &get_instance();
    if ('' != $whrArr) {
        $CI->db->where($whrArr);
    }

    return $CI->db->get($table)->row();
}
function getLastRow($table)
{
    $CI = &get_instance();
    return $CI->db->limit(1)->order_by('id', 'desc')->get($table)->row();
}

function insertRow($table, $data)
{
    $CI = &get_instance();
    if (!$CI->db->insert($table, $data)) {
        return response(false, $CI->db->error()['message']);
    }
    if (0 == $CI->db->affected_rows()) {
        return response(false, 'Insert Failed');
    }

    return response(true, $CI->db->insert_id());
}
function insertOrUpdate($table, $whrArr, $dataArr)
{
    if (empty(getRow($table, $whrArr))) {
        return insertRow($table, $dataArr);
    }

    return updateRow($table, $whrArr, $dataArr);
}

function updateRow($table, $whrArr, $data)
{
    $CI = &get_instance();
    $CI->db->where($whrArr);
    if (!$query = $CI->db->update($table, $data)) {
        return response(false, $CI->db->error()['message']);
    }
    if (0 == $CI->db->affected_rows()) {
        return response(false, 'No Changes were Made, Update Failed');
    }

    return response(true);
}

function replaceRow($table, $whrArr, $data)
{
    $CI = &get_instance();
    $CI->db->where($whrArr);
    if (!$query = $CI->db->replace($table, $data)) {
        return response(false, $CI->db->error()['message']);
    }
    if (0 == $CI->db->affected_rows()) {
        return response(false, 'Replace Failed');
    }

    return response(true);
}

function deleteRow($table, $whrArr)
{
    $CI = &get_instance();
    $CI->db->where($whrArr);
    if (!$query = $CI->db->delete($table)) {
        return response(false, $CI->db->error()['message']);
    }
    if (0 == $CI->db->affected_rows()) {
        return response(false, 'delete Failed');
    }

    return response(true);
}
