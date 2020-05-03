<?php

//HEADERS (open access)
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/database.php';
include_once '../../models/post.php';

//initialise db & connect
$database = new Database();
$db = $database->connect();

//initialise post blog
$post = new Post($db);

//BP query
$resultaat = $post->read();

//row count
$num = $resultaat->rowCount();

//controleer op posts
if($num >0){
    //post array
    $post_arr = array();
    $post_arr['data'] = array();

    while($row = $resultaat->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $post_item = array(
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body),
            'author' => $author,
            'category_id' => $category_id,
            $category_name => $category_name
        );
        //push naar data
        array_push($post_arr['data'], $post_item);
    }
    //return naar json
    echo json_encode($post_arr);
}
else{
    //geen posts
    echo json_encode(
        array('message' => 'No posts found')
    );
}

