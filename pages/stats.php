<?php

$fragment = new rex_fragment();

$list = rex_list::factory('select id, timestamp, page, referer from naju_visitor_stat order by timestamp desc');

$fragment->setVar('content', $list->get(), false);
echo $fragment->parse('core/page/section.php');
