<?php

$funcs = array('revoke', 'generate');
$func = rex_get('func');

if (in_array($func, $funcs)) {
    switch ($func) {
        case 'generate':
            $alias = rex_post('alias', 'string', null);
            $token = naju_credentials::generateToken();
            rex_sql::factory()
                ->setTable('naju_stat_credential')
                ->setValues(['alias' => $alias, 'token' => $token])
                ->insert();
            break;
        case 'revoke':
            $token = rex_get('token');
            rex_sql::factory()->setQuery('delete from naju_stat_credential where token = :token limit 1', ['token' => $token]);
            break;
    }
}

$fragment = new rex_fragment();
$content = '';

$tokens = rex_sql::factory()->setQuery('select token, alias from naju_stat_credential')->getArray();

$token_table = <<<EOHTML
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Token</th>
                <th>Bearbeiten</th>
            </tr>
        </thead>
        <tbody>
EOHTML;

foreach ($tokens as $token) {
    $token_table .= '<tr>';
    $token_table .= '<td>' . htmlspecialchars($token['alias'] ?? '') . '</td>';
    $token_table .= '<td><code>' . htmlspecialchars($token['token']) . '</code></td>';
    $token_table .= '<td>
        <a href="' . rex_url::currentBackendPage(['func' => 'revoke', 'token' => urlencode($token['token'])]) . '">' .
            '<i class="rex-icon rex-icon-delete"></i> revoke
        </a>
    </td>';
    $token_table .= '</tr>';
}

$token_table .= '</tbody></table>';

$formaction = rex_url::currentBackendPage(['func' => 'generate']);
$form = <<<EOHTML
    <form action="$formaction" method="post" style="margin: 15px;">
        <div class="form-group">
            <label for="token-alias">Token generieren</label>
            <input type="text" name="alias" id="token-alias" placeholder="Alias" class="form-control">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Erstellen</button> 
        </div>
    </form>
EOHTML;

$content .= $token_table . '<hr>' . $form;

$fragment->setVar('content', $content, false);
echo $fragment->parse('core/page/section.php');
