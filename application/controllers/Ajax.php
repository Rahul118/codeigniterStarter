<?php
defined('BASEPATH') or exit('No direct script access allowed');

// header("Access-Control-Allow-Origin: *");

header('Content-type: application/json');

class Ajax extends MY_Controller
{
    public function index()
    {
        redirects();
    }

    /*** GET REQUEST */
    public function getRows($table)
    {
        response_json(true, getRows($table));
    }

    /*** GET REQUEST */
    public function getRow($table, $whrKey, $whrValue)
    {
        response_json(true, getRow($table, array($whrKey => $whrValue)));
    }

    /*** GET REQUEST */
    public function deleteRow($table, $whrKey, $whrValue)
    {
        $res = deleteRow($table, array($whrKey => $whrValue));
        response_json($res->success, $res->data);
    }
    /*** POST REQUEST */
    public function replaceRow($table, $whrKey, $whrValue)
    {
        $res = replaceRow($table, array($whrKey => $whrValue), $this->input->post());
        response_json($res->success, $res->data);
    }
    /*** POST REQUEST */
    public function updateRow($table, $whrKey, $whrValue)
    {
        $res = updateRow($table, array($whrKey => $whrValue), $this->input->post());
        response_json($res->success, $res->data);
    }
    /*** POST REQUEST */
    public function insertRow($table)
    {
        $res = insertRow($table, $this->input->post());
        response_json($res->success, $res->data);
    }
    /*** POST REQUEST */
    public function insertOrUpdate($table, $whrKey, $whrValue)
    {
        $res = insertOrUpdate($table, array($whrKey => $whrValue), $this->input->post());
        response_json($res->success, $res->data);
    }
}
