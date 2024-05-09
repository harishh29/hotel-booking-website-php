<?php

$servername = 'localhost:3308';
$username = 'root';
$password = '';
$db = 'hoteldb';


$con = mysqli_connect($servername,$username,$password,$db);

if(!$con){
    die("Connection failed".mysqli_connect_error());
}

function filteration($data){
    foreach($data as $key => $value){
        $value = trim($value);
        $value = stripslashes($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value);
        

        $data[$key] = $value;
    }
    return $data;
}


function selectAll($table){
    $con = $GLOBALS['con'];
    $res = mysqli_query($con, "SELECT * FROM $table");
    return $res;
}

function select($sql, $values, $datatypes){
    $con = $GLOBALS['con'];
    if($stmt = mysqli_prepare($con, $sql)){
        mysqli_stmt_bind_param($stmt, $datatypes,...$values);
        if(mysqli_stmt_execute($stmt)){
            $res = mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        }
        else{
            die("Unable to execute query - Select");
        }
        
    }
    else{
        die("Unable to prepare query - Select");
    }
}

function update($sql, $values, $datatypes){
    $con = $GLOBALS['con'];
    if($stmt = mysqli_prepare($con, $sql)){
        mysqli_stmt_bind_param($stmt, $datatypes,...$values);
        if(mysqli_stmt_execute($stmt)){
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        }
        else{
            die("Unable to execute query - Update");
        }
        
    }
    else{
        die("Unable to prepare query - Update");
    }
}

function insert($sql, $values, $datatypes){
    $con = $GLOBALS['con'];
    if($stmt = mysqli_prepare($con, $sql)){
        mysqli_stmt_bind_param($stmt, $datatypes,...$values);
        if(mysqli_stmt_execute($stmt)){
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        }
        else{
            die("Unable to execute query - Insert");
        }
        
    }
    else{
        die("Unable to prepare query - Insert");
    }
}

function delete($sql, $values, $datatypes){
    $con = $GLOBALS['con'];
    if($stmt = mysqli_prepare($con, $sql)){
        mysqli_stmt_bind_param($stmt, $datatypes,...$values);
        if(mysqli_stmt_execute($stmt)){
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        }
        else{
            die("Unable to execute query - Delete");
        }
        
    }
    else{
        die("Unable to prepare query - Delete");
    }
}


?>