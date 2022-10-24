<?php

require_once MODX_CORE_PATH . 'model/modx/processors/resource/getlist.class.php';

class SearchResource extends modResourceGetListProcessor
{
    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        $query = $this->getProperty('query');
        $current = $this->getProperty('current');

        if ($current) {
            $c->where([
                'AND:id:!=' => $current,
            ]);
        }

        if (!empty($query)) {
            if (is_numeric($query)) {
                $c->where([
                    'id' => $query,
                ]);

                return $c;
            }

            $c->where([
                'pagetitle:LIKE' => "%$query%",
                'OR:longtitle:LIKE' => "%$query%",
                'OR:uri:LIKE' => "%$query%",
            ]);
        }

        return $c;
    }
}

return SearchResource::class;
