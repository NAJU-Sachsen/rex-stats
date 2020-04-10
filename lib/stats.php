<?php

class naju_stats
{
    public static function logVisitor()
    {
        // the $nostats flag may be set to indicate that for the current request no
        // stats should be gathered. However, the flag will be mostly absent.
        // Hence the slightly complicated check whether the flag is there and
        // actually set to true
        if (!($nostats ?? false)) {
            $page = rex_getUrl();
            $timestamp = date('Y-m-d H:i:s');

            $sql = rex_sql::factory();
            $sql->setTable('naju_visitor_stat');

            $stats = ['timestamp' => $timestamp, 'page' => $page];

            // check if referer information is present and add it if so
            $referer = rex_server('HTTP_REFERER');
            if ($referer) {
                $stats['referer'] = $referer;
            }

            $sql->setValues($stats);
            $sql->insert();
        }
    }

    public static function fetchStats($from=null, $to=null)
    {
        $sql = rex_sql::factory();
        $where_clause = '';
        $from_clause = '';
        $to_clause = '';
        $params = array();

        if ($from) {
            $from_clause = 'timestamp >= :from';
            $params['from'] = $from;
        }

        if ($to) {
            $to_clause = 'timestamp <= :to';
            $params['to'] = $to;
        }

        if ($from && $to) {
            $where_clause = $from_clause . ' and ' . $to_clause;
        } else {
            $where_clause = $from_clause . $to_clause; // if not from and to (at least) one of them will be empty
        }

        if ($where_clause) {
            $where_clause = ' where ' . $where_clause;
        }

        $query = <<<EOSQL
            select timestamp, page, referer
            from naju_visitor_stat
            $where_clause
EOSQL;

        return $sql->setQuery($query, $params)->getArray();
    }

}
