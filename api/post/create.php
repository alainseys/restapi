<?php
//HEADERS (open access)
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
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

//toewijzen van data naar post object
$post->title = $data->title;
$post->body = $data->body;
$post->author = $data->author;
$post->category_id = $data->category_id;

//create post
if($post->create()) {
   echo json_encode(
       array('message' => 'Post Created')
   );
}else{
    echo json_encode(
    array('message' => 'Post Not Created!')
    );
}
