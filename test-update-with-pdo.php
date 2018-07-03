<?php
//https://tudorbarbu.ninja/multithreading-in-php/
//https://github.com/motanelu/php-thread/blob/master/Thread.php
require_once( 'Thread.php' );

/*$server='dbm1.qmobility.qualys.com:50827';
$username = 'qmdc_prod';
$password='kC8!DkuJkQbBmT#S+Nwn';
$database='qmerdb';*/



// test to see if threading is available
if( ! Thread::isAvailable() ) {
    die( 'Threads not supported' );
}

// function to be ran on separate threads
function paralel( $_limit, $_name ) {
    /*$server='localhost';
    $username = 'qmemm_dev';
    $password='Qmobility@123';
    $database='qmerdb_dev_11';*/

    $server='localhost';
    $username = 'testuser';
    $password='kC8!DkuJkQbBmT#S+Nwn';
    $database='testdb';
    $dbh=array();
    for ( $index = 0; $index < $_limit; $index++ ) {
        echo 'Now running thread ' . $_name . PHP_EOL;
        try {
            if(isset($dbh[$_name]) && $dbh[$_name] instanceof PDO) {
                // your code
                echo 'Active PDO object found for thread:'.$_name." so Not making connection".PHP_EOL;
            } else {
                $dbh[$_name] = new PDO("mysql:host=$server;dbname=$database", $username, $password, array(PDO::ATTR_PERSISTENT => true));

                echo "Making Connection for thread:".$_name.PHP_EOL;
            }
            //$dbh[$_name]->query("SELECT * FROM City where StateID=$nu");
            $nu = mt_rand(1,3347);
            foreach($dbh[$_name]->query("SELECT * FROM City where StateID=$nu") as $row) {
                //print_r($row);
            }
        } catch (Exception $e) {
            echo "Connection refused for thread:".$_name.PHP_EOL;
        }


        sleep( 1 );
    }
}

// create 2 thread objects
for($i = 0; $i < 50; $i++) {
    $threads[$i] = new Thread( 'paralel');
    $threads[$i]->start(20,'t'.$i);
}


// keep the program running until the threads finish
while( $threads[0]->isAlive() && $threads[2]->isAlive() ) {
    sleep(1);
}



