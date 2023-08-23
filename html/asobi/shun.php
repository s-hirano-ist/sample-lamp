<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>sample title</title>
</head>

<body>
    <?php
    $tsuki = $_POST['tsuki'];

    // $yasai[] = Array('1','2'); # この書き方もあるよ
    $yasai[] = '';
    $yasai[] = 'ブロッコリー';
    $yasai[] = 'カリフラワー';
    $yasai[] = 'レタス';
    $yasai[] = 'みつば';
    $yasai[] = 'アスパラガス';
    $yasai[] = 'セロリ';
    $yasai[] = 'ナス';
    $yasai[] = 'ピーマン';
    $yasai[] = 'オクラ';
    $yasai[] = 'さつまいも';
    $yasai[] = '大根';
    $yasai[] = 'ほうれんそう';

    print $tsuki;
    print '月は';
    print $yasai[$tsuki];
    print 'が旬です。';
    ?>
</body>

</html>
