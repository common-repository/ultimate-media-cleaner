<?php

//TODO: try this bomb
//
//function searchAllDB($search){
//    global $mysqli;
//
//    $out = "";
//
//    $sql = "show tables";
//    $rs = $mysqli->query($sql);
//    if($rs->num_rows > 0){
//        while($r = $rs->fetch_array()){
//            $table = $r[0];
//            $out .= $table.";";
//            $sql_search = "select * from ".$table." where ";
//            $sql_search_fields = Array();
//            $sql2 = "SHOW COLUMNS FROM ".$table;
//            $rs2 = $mysqli->query($sql2);
//            if($rs2->num_rows > 0){
//                while($r2 = $rs2->fetch_array()){
//                    $column = $r2[0];
//                    $sql_search_fields[] = $column." like('%".$search."%')";
//                }
//                $rs2->close();
//            }
//            $sql_search .= implode(" OR ", $sql_search_fields);
//            $rs3 = $mysqli->query($sql_search);
//            $out .= $rs3->num_rows."\n";
//            if($rs3->num_rows > 0){
//                $rs3->close();
//            }
//        }
//        $rs->close();
//    }
//
//    return $out;
//}
