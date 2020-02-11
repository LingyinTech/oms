<?php


namespace lingyin\traits;


trait JsonResultTrait
{

    public $result = ['status' => 0, 'msg' => 'success'];

    /**
     * @param null $data
     * @return false|string
     */
    protected function format($data = null)
    {
        $result = [];
        if (is_array($data)) {
            $result = $data;
        } elseif (is_bool($data) || is_int($data)) {
            $result['status'] = empty($data) ? 1 : 0;
            $result['msg'] = empty($data) ? 'fail' : 'success';
        } elseif (is_string($data)) {
            $result['data'] = $data;
        } elseif (is_object($data)) {
            $result = (array)$data;
        }

        return json_encode(array_merge($this->result, $result));
    }

    protected function fail($msg, $errors = null)
    {
        $result = ['status' => 1, 'msg' => $msg];
        if ($errors) $result['errors'] = $errors;
        return $this->format($result);
    }

    protected function success($msg)
    {
        return $this->format(['msg' => $msg]);
    }

}