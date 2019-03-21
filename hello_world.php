<!DOCTYPE HTML>
<html>

<head>
  <title>PHP Test</title>
</head>

<body>
  <?php
    echo "<p>Hello World</p>\n";

    // Variables begin with the $ symbol.
    $a = 12;
    $b = -8;
    $c = $a + $b;

    // Note the differences between single and double quote
    echo "<p>";
    echo '{$a} + {$b} = ';
    echo "{$a} + {$b} = ";
    echo "{$c}";
    echo "</p>\n";
    
    // All arrays in PHP are associative arrays (hashmaps in some languages)
    $arr = array('height' => 180, 'weight' => 70, 'age' => 25);
    echo "<p>{$arr['height']}</p>\n";

    // for loop
    echo "<p>";
    for ($i = 0; $i < 3; $i++) {
        if ($i === 1) {
            continue; // Skip this iteration of the loop
        }
        echo $i;
    }
    echo "</p>\n";
  ?>
</body>

</html>