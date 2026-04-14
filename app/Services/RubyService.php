<?php
namespace App\Services;

class RubyService{
    public function addRuby(string $html): string {
    $result = '';
    $cmd = "echo " . escapeshellarg($html) . " | /usr/bin/mecab";
    //var_dump($cmd);
    $output = shell_exec($cmd);
    //var_dump($output);
    $lines = explode("\n", $output);

    foreach ($lines as $line) {
        $parts = explode("\t", $line,2 );

        if (count($parts) < 2) continue; // 分割できなかった時用

        $features = explode(",", $parts[1]);
        if (!isset($features[7])){
            $result .= $parts[0];
            continue;
        };
        $hiragana = mb_convert_kana($features[7], 'c');

        if (preg_match('/[一-龯]/u', $parts[0])) {
            $ruby = "<ruby>" . $parts[0]. "<rt>". $hiragana . "</rt></ruby>";
        } else {
            $ruby = $parts[0];
        }
        $result .= $ruby;
    }
        return $result;
}
}