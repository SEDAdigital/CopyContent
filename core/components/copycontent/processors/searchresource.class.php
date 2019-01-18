<?php

require_once MODX_CORE_PATH . 'model/modx/processors/resource/getlist.class.php';

class SearchResource extends modResourceGetListProcessor
{
    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        $query = $this->getProperty('query');
        $current = $this->getProperty('current');
        if (!empty($query)) {
            $c->where([
                'pagetitle:LIKE' => "%$query%",
                'OR:id:LIKE' => "%$query%",
                'OR:longtitle:LIKE' => "%$query%",
                'OR:uri:LIKE' => "%$query%",
            ]);
        }
        if ($current) {
            $c->where([
                'AND:id:!=' => $current,
            ]);
        }

        return $c;
    }
}

return SearchResource::class;
