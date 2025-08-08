<?php
echo "Willkommen bei smartShoppingList!";
$test="<h2>geil</h2>";
$string="hallo";
$number=2;
$float =2.5;

$date = new DateTime();

$array = ["miau", "wau", "geil"];
$array = ["hund" => ["atlas", "loki"], "katz" => [] ];

function printDate(DateTime $date) {
    echo $date->format('d.m.Y');
}

enum dogs
{
    case Atlas;
    case Loki;

}


class dog
{
    private ?string $race = null;

    public function __construct(?string $race = null)
    {
        $this->race = $race;
    }
    public function getRace(): string
    {
        return $this->race;
    }

    public function bark(): void
    {
        echo "wau";
    }

    public function __toString(): string
    {
        return $this->race;
    }

}

$atlas = new dog("labischefer");



?>
<h1>hallo</h1>
<?php
echo printDate(new DateTime());
$atlas->bark();
echo "<br>";
echo "<br>";
echo "<br>";

var_dump($_REQUEST);
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
var_dump($_ENV);
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";

echo $atlas;
?>