<?php


namespace lingyin\traits;


trait ListTreeTrait
{

    /**
     * @param array $list
     * @param int $rootId
     * @param string $primaryKey
     * @param string $pidKey
     * @param string $child
     * @return array
     */
    public function list2Tree($list, $rootId = 0, $primaryKey = 'id', $pidKey = 'pid', $child = 'items')
    {
        if (empty($list) || !is_array($list)) {
            return [];
        }

        $tree = [];

        $refer = [];
        foreach ($list as $key => $data) {
            $refer[$data[$primaryKey]] = &$list[$key];
        }

        foreach ($list as $key => $data) {
            if ($rootId == $data[$pidKey]) {
                $tree[] = &$list[$key];
            } elseif (isset($refer[$data[$pidKey]])) {
                $parent = &$refer[$data[$pidKey]];
                $parent[$child][] = &$list[$key];
            }
        }

        return $tree;
    }

}