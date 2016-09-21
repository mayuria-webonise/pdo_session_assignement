<?php
function sqlPdo($query,$queryType,$databaseType){
    if(!strcmp($databaseType,'mysql'))
    {
        $hostname='localhost';
        $databaseUsername='root';
        $databasePassword='mayuri123#';
        try {
            $DatabaseDriver = new PDO("mysql:host=$hostname;dbname=e_commerce", $databaseUsername, $databasePassword);
        }catch (Exception $e){
            echo $e->getMessage();
        }

    }
    elseif(!strcmp($databaseType,'pgsql'))
    {
        $hostname='localhost';
        $databaseUsername='postgres';
        $databasePassword='mayuri123#';
        try {
            $DatabaseDriver = new PDO("pgsql:dbname=first;host=$hostname;user=$databaseUsername;password=$databasePassword");
        }catch (Exception $e){
            echo $e->getMessage();
        }
    }
    elseif(!strcmp($databaseType,'sqlite')){
        try{
            $DatabaseDriver = new PDO("sqlite:".__DIR__."/sqliteDatabase.db");
        }
        catch(Exception $e){
            echo $e->getMessage();
        }

    }
    $statementPrepared=$DatabaseDriver->prepare($query);
    if(!strcmp($queryType,'insert'))
    {
        if($statementPrepared->execute()){
            echo "successful insertion";
        }
        else{
            echo "unsuccessful";
        }
    }
    elseif(!strcmp($queryType,'select'))
    {
        $statementPrepared->execute();
        $result = $statementPrepared->fetchAll(PDO::FETCH_CLASS);
        if(empty($result))
        {
            return false;
        }
        else
        {
            echo '<pre>',print_r($result);
        }
    }
}

if(isset($_POST['mysql']))
{
    sqlPdo( "INSERT INTO users (idusers, user_name, email,password)
VALUES (9,'Prajakta','prajkta@gmail.com','mayuri')","insert",'mysql');
    sqlpdo('select * from users','select','mysql');
}
if(isset($_POST['postgresql']))
{
    sqlPdo("INSERT INTO company (id, name,age,address,salary)
    VALUES (2,'Prajakta',22,'Pune',50000)",'insert','pgsql');
    sqlpdo('select * from company','select','pgsql');
}

if(isset($_POST['sqlite']))
{
    sqlPdo("INSERT INTO users (id,user_name,age,address,salary)
    VALUES (2,'Prajakta',22,'Pune',50000);",'insert','sqlite');
    sqlpdo('select * from users','select','sqlite');
}
?>
<html>
<head>
    <title>Login Page</title>
</head>
<body>
<form action="index.php" method="post">
    <input type="submit" name="mysql" value="mysql"><br/>
    <input type="submit" name="postgresql" value="postgresql"><br/>
    <input type="submit" name="sqlite" value="sqlite">
</form>
</body>
</html>