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

//get id from url
$post->id = isset($_GET['id']) ? $_GET['id'] : die();

//lezen van de single method
$post->read_single();

//maak een array
$post_arr = array(
    'id'            => $post->id,
    'title'         => $post->title,
    'body'          => $post->body,
    'author'        => $post->author,
    'category_id'   => $post->category_id,
    'category_name' => $post->category_name
);

//maak json
print_r(json_encode($post_arr));