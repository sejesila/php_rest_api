<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

//Instantiate db and connect
$database = new Database();
$db = $database->connect();
//instantiate blog post object
$post = new Post($db);
//Blog post query
$result = $post->read();
//get row count
$num = $result->rowCount();
//check if any post
if ($num>0){
//post array
    $post_arr = array();
    $post_arr['post data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $post_item = array(
            'id'=>$id,
            'title'=>$title,
            'body'=>html_entity_decode($body),
            'author'=>$author,
            'category_id'=>$category_id,
            'category_name'=>$category_name,
        );

        //push to the array
        //array_push($post_arr['post data'],$post_item);
        $post_arr['post data'][] = $post_item;
    }
    //turn it to json and output
    echo json_encode($post_arr);
}else{
    echo json_encode(
        array('Message'=>'No posts found')
    );

}
