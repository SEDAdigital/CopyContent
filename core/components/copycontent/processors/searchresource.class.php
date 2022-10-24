<?php

use MODX\Revolution\modContext;

class SearchResource extends \MODX\Revolution\Processors\Resource\GetList
{
    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        $c->leftJoin(modContext::class, 'Context');

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
