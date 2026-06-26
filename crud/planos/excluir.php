<?php

include "../../conexao.php";

$id=$_GET['id'];

mysqli_query($conn,"DELETE FROM planos WHERE id_plano=$id");

header("Location:listar.php");