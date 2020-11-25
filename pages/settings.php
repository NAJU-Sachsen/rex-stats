<?php

$func = rex_request('func', 'string', '');

$msg = '';

if ($func === 'stats_clear') {
    rex_sql::factory()->setTable('naju_visitor_stat')->delete();
    $msg .= '<div class="alert alert-info">Statistiken wurden zurückgesetzt</div>';
}

$fragment = new rex_fragment();

$content = '';

$content .= '
    <form method="post" action="' . rex_url::currentBackendPage(['func' => 'stats_clear']) . '">
        <div class="form-group">
            <label for="clear-stats">Statistiken zurücksetzen</label>
            <button type="submit" id="clear-stats" class="btn btn-link">
                <i class="rex-icon fa-cogs"></i> ausführen
            </button>
        </div>
    </form>
';

$fragment->setVar('title', 'Optionen', false);
$fragment->setVar('class', 'edit', false);
$fragment->setVar('body', $msg . $content, false);
echo $fragment->parse('core/page/section.php');
