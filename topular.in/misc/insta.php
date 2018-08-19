<?php
	require('Instaphp/Instaphp.php');
	
    $api = new Instaphp\Instaphp([
        'client_id' => '5620ba77c9e24426a08b5ce0f6ef0cc9',
        'client_secret' => 'b009f40d6cb9448fbdc88982ff0ec73a',
        'redirect_uri' => 'http://topular.in',
        'scope' => 'comments+likes'
    ]);

    $popular = $api->Media->Popular(['count' => 10]);

    if (empty($popular->error)) {
        foreach ($popular->data as $item) {
            printf('<img src="%s">', $item['images']['low_resolution']['url']);
        }
    }
?>