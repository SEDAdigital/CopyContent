<?php

declare(strict_types=1);

namespace CopyContent\Processor;

use MODX\Revolution\modContext;
use MODX\Revolution\Processors\Resource\GetList;
use xPDO\Om\xPDOQuery;

final class SearchResource extends GetList
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
