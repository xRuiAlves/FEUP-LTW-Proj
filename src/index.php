<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <?php
        include_once('db/db_selectors.php');

        echo "User 1 vote on Entity 4: ";
        print_r(getUserEntityVote(1,4));
        echo "<br><br>";
        echo "User 2 vote on Entity 2: ";
        print_r(getUserEntityVote(2,2));
        echo "<br><br>";
        echo "User 1 vote on Entity 123: ";
        print_r(getUserEntityVote(1,123));

        echo "<br><br>";
        echo "<br><br>";

        echo "Entity Number 4: <br>";
        echo "UP: "; echo getEntityNumUpVotes(4);
        echo "<br>";
        echo "Down: "; echo getEntityNumDownVotes(4);
        echo "<br><br>";
        echo "Entity Number 1: <br>";
        echo "UP: "; echo getEntityNumUpVotes(1);
        echo "<br>";
        echo "Down: "; echo getEntityNumDownVotes(1);
        echo "<br><br>";
        echo "Entity Number 7: <br>";
        echo "UP: "; echo getEntityNumUpVotes(7);
        echo "<br>";
        echo "Down: "; echo getEntityNumDownVotes(7);
    ?>
</body>
</html>