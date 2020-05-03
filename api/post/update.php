<?php
//HEADERS (open access)
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../config/database.php';
include_once '../../models/post.php';

//initialise db & connect
$database = new Database();
$db = $database->connect();

//initialise post blog
$post = new Post($db);

//get raw posted data
$data = json_decode(file_get_contents("php://input"));

//update ID
$post->id = $data->id;


//toewijzen van data naar post object
$post->title = $data->title;
$post->body = $data->body;
$post->author = $data->author;
$post->category_id = $data->category_id;

//update post
if($post->update()) {
    echo json_encode(
        array('message' => 'Post Updated')
    );
}else{
    echo json_encode(
        array('message' => 'Post Not Updated!')
    );
}
