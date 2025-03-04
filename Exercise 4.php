<?php
echo "<table border='1' style='border-collapse: collapse; width: 20%; margin: 0 auto;'>";

for ($row = 1; $row <= 7; $row++) {
    for ($col = 1; $col <= 7; $col++) {
        $product = $row * $col;
        echo "<td>$product</td>";
    }
    echo "</tr>";
}

echo "</table>";
?>
