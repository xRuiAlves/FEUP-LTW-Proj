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

        echo "<br><br>";
        echo "<br><br>";

        echo "User 1 score: ";
        print_r(getUserPoints(1));
        echo "<br>";
        echo "User 2 score: ";
        print_r(getUserPoints(2));
        echo "<br>";
        echo "User 3 score: ";
        print_r(getUserPoints(3));
        echo "<br>";
        echo "User 4 score: ";
        print_r(getUserPoints(4));

        echo "<br><br>";
        echo "<br><br>";

        echo "User 1 stories: ";
        print_r(getUserStories(1));
        echo "<br>";
        echo "User 2 stories: ";
        print_r(getUserStories(2));
        echo "<br>";
        echo "User 3 stories: ";
        print_r(getUserStories(3));
        echo "<br>";
        echo "User 4 stories: ";
        print_r(getUserStories(4));

        echo "<br><br>";
        echo "<br><br>";

        echo "Entity 1 comments: ";
        print_r(getEntityComments(1));
        echo "<br>";
        echo "Entity 2 comments: ";
        print_r(getEntityComments(2));
        echo "<br>";
        echo "Entity 3 comments: ";
        print_r(getEntityComments(3));
        echo "<br>";
        echo "Entity 4 comments: ";
        print_r(getEntityComments(4));
        echo "<br>";
        echo "Entity 5 comments: ";
        print_r(getEntityComments(5));
        echo "<br>";
        echo "Entity 6 comments: ";
        print_r(getEntityComments(6));
        echo "<br>";
        echo "Entity 7 comments: ";
        print_r(getEntityComments(7));
        echo "<br>";
        echo "Entity 8 comments: ";
        print_r(getEntityComments(8));
    ?>
</body>
</html>