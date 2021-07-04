<?php
$POPULATION = array();
$POPULATION_SIZE = 100;
$DNA_SIZE = 5;
$GEN_COUNT = 1;
$TEST_COUNT = 0;

genInitPopulation();
while (true) {
    naturalSelection();
    recreatePopulation();
}

function mutate($s) {
    global $DNA_SIZE;
    $sample = randomIndividual();
    for ($i=0; $i<$DNA_SIZE; $i++) {
        if (rand(0,100) == 100) {
            $s[$i] = $sample[$i];
        }
    }
    return $s;
}

function reproduction($ia, $ib)
{
    global $DNA_SIZE;
    $crosspoint   = rand(0, $DNA_SIZE-1);
    $ia_before_cp = substr($ia, 0, $crosspoint);
    $ib_after_cp  = substr($ib, $crosspoint);
    $child = $ia_before_cp.$ib_after_cp;
    $child = mutate($child);
    return array($child, fitness($child));
}

function recreatePopulation()
{
    global $POPULATION, $POPULATION_SIZE, $GEN_COUNT;
    //echo '* Recreating population by reproducing randomly...'."<br>";
    $GEN_COUNT++;
    $c = count($POPULATION);
    for ($i=$c; $i<$POPULATION_SIZE; $i++) {
        $a = rand(0, $c-1);
        $b = rand(0, $c-1);
        array_push($POPULATION, reproduction($POPULATION[$a][0], $POPULATION[$b][0]));
    }
}

function naturalSelection()
{
    global $POPULATION, $POPULATION_SIZE, $GEN_COUNT;
    //echo '* Natural selection...'."<br>";
    usort($POPULATION, "cmp");
    array_splice($POPULATION, ceil($POPULATION_SIZE/2));
    echo 'Best in generation '.$GEN_COUNT.': '.$POPULATION[0][0].' ('.$POPULATION[0][1].')'."<br>";
}

function cmp($a, $b)
{
    if ($a[1] == $b[1]) return 0;
    return ($a[1] > $b[1]) ? -1 : 1;
}

function genInitPopulation()
{
    global $POPULATION, $POPULATION_SIZE;
    //echo '* Generating inital population...'."<br>";
    for($i=0; $i<$POPULATION_SIZE; $i++) {
        $individual = randomIndividual();
        array_push($POPULATION, array($individual,fitness($individual)));
    }
}

function randomIndividual()
{
    global $DNA_SIZE;
    $individual = '';
    for($i=0; $i<$DNA_SIZE; $i++) {
        $individual .= str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')[0];
    }
    return $individual;
}


function fitness($individual)
{
    global $GEN_COUNT, $POPULATION_SIZE, $TEST_COUNT;
    $TEST_COUNT++;
    $goal = 'Hello';
    $delta = 0;
    for($i=0; $i<strlen($individual); $i++) {
        $delta -= abs(ord($goal[$i]) - ord($individual[$i]));
    }
    if ($delta == 0) {
        echo "<br>".'Solution found in '.$GEN_COUNT.' generation(s) of '.$POPULATION_SIZE.' individual(s)!'."<br>";
        echo '>>'.$individual."<br><br>";
        echo 'There was '.$TEST_COUNT.' tests performed'."<br>";
        echo 'Out of 380 204 032 possible combinations'."<br>";
        exit();
    }
    return $delta;
}
?>
