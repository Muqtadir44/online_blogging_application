<?php

// date_default_timezone_set('Asia/Karachi');

require 'database_settings.php';

class database{

    public $hostname;
    public $username;
    public $password;
    public $database;
    public $connection;
    public $query;
    public $result;

    public function __construct($hostname,$username,$password,$database)
    {
        $this->hostname  = $hostname;
        $this->username  = $username;
        $this->password  = $password;
        $this->database  = $database;
        mysqli_report(FALSE);
        $this->connection = mysqli_connect($this->hostname,$this->username,$this->password,$this->database);
        if (mysqli_connect_errno()) {
            die("Database Connection Failed");
        }
    }

    public function register_user($first_name,$last_name,$email,$password,$gender,$date_of_birth,$address,$path)
    {
        $this->query = "INSERT INTO users(first_name,last_name,email,password,gender,date_of_birth,address,profile_picture,created_at)
        VALUES('{$first_name}','{$last_name}','{$email}','{$password}','{$gender}','{$date_of_birth}','{$address}','{$path}',NOW())";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function email_check($email){
        $this->query  = "SELECT * FROM users WHERE email = '{$email}'";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function login($email,$password){
        $this->query  = "SELECT * FROM users WHERE email = '{$email}' AND password = '{$password}'";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function file_generate($email){
        $this->query  = "SELECT * FROM users WHERE email = '{$email}'";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function posts_statistics(){
        $this->query  = "SELECT COUNT(*) AS post_statistics FROM post";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function blogs_statistics(){
        $this->query  = "SELECT COUNT(*) AS blog_statistics FROM blog";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function users_statistics(){
        $this->query  = "SELECT COUNT(*) AS users_statistics FROM users";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function categories_statistics(){
        $this->query  = "SELECT COUNT(*) AS categories_statistics FROM category";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function feedback_statistics(){
        $this->query  = "SELECT COUNT(*) AS feedback_statistics FROM feedback";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    /*----User Start ----*/
    public function user_request(){
        $this->query  = "SELECT * FROM users WHERE state = 'Pending' ORDER BY user_id DESC";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result; 
    }

    public function approve_user($user_id){
        $this->query = "UPDATE users SET state = 'Approved' , status = 'Active' WHERE user_id = $user_id";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function user_record($user_id){
        $this->query  = "SELECT * FROM users WHERE user_id = $user_id";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result; 
    }

    public function roles(){
        $this->query  = "SELECT * FROM role";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result; 
    }

    public function reject_user($user_id){
        $this->query = "UPDATE users SET state = 'Rejected',status = 'Inactive' WHERE user_id = $user_id";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function dashboard_add_user($role_id,$first_name,$last_name,$email,$password,$gender,$date_of_birth,$address,$path){
        $this->query = "INSERT INTO users(role_id,first_name,last_name,email,password,gender,date_of_birth,address,profile_picture,status,state,created_at)
        VALUES('{$role_id}','{$first_name}','{$last_name}','{$email}','{$password}','{$gender}','{$date_of_birth}','{$address}','{$path}','Active','Approved',NOW())";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function all_users($user_id){
        $this->query  = "SELECT * FROM users u INNER JOIN role r ON u.`role_id` = r.`role_id`
        WHERE u.state = 'Approved' AND u.status != 'Delete' AND u.`user_id` != $user_id ORDER BY u.`user_id` DESC";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function rejected_users(){
        $this->query  = "SELECT * FROM users WHERE state='rejected' AND status != 'Delete'  ORDER BY user_id DESC";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;  
    }

    public function updating_user($user_id,$role_id,$first_name,$last_name,$gender,$date_of_birth,$address){
        $this->query  = "UPDATE users SET role_id = '{$role_id}', first_name = '{$first_name}',last_name = '{$last_name}',gender = '{$gender}',
                        date_of_birth = '{$date_of_birth}', address = '{$address}',updated_at = NOW() WHERE user_id = $user_id";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;        

    }

    public function delete_user($user_id){
        $this->query  = "UPDATE users SET status = 'Delete' WHERE user_id = $user_id";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;        
    }

    public function updating_user_with_picture($user_id,$role_id,$first_name,$last_name,$gender,$date_of_birth,$address,$path){
        $this->query  = "UPDATE users SET role_id = '{$role_id}', first_name = '{$first_name}',last_name = '{$last_name}',gender = '{$gender}',
                        date_of_birth = '{$date_of_birth}',address = '{$address}',profile_picture = '{$path}',updated_at = NOW() WHERE user_id = $user_id";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;        

    }

    public function update_status($user_id,$status){
        $this->query  = "UPDATE users SET status = '{$status}' WHERE user_id = $user_id";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }
    /*----User End ----*/

    /*----Blog Start ----*/
    public function creating_blog($user_id,$blog_title,$blog_summary,$post_per_page,$path){
        $this->query  = "INSERT INTO blog(user_id,blog_title,blog_summary,post_per_page,blog_background_image,created_at)
                        VALUES($user_id,'{$blog_title}','{$blog_summary}',$post_per_page,'{$path}',NOW())";
        $this->result = $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function blog_record($blog_id){
        $this->query  = "SELECT * FROM blog WHERE blog_id = $blog_id";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function post_per_page(){
        $this->query  = "SELECT post_per_page FROM blog";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function blogs(){
        $this->query  = "SELECT * FROM blog WHERE status != 'Delete' ORDER BY blog_id DESC";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function blog_status($blog_id,$status){
        $this->query  = "UPDATE blog SET status = '{$status}' WHERE blog_id = $blog_id";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function delete_blog($blog_id){
        $this->query  = "UPDATE blog SET status = 'Delete' WHERE blog_id = $blog_id";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function updating_blog($blog_id,$blog_title,$blog_summary,$post_per_page){
        $this->query = "UPDATE blog SET blog_title = '{$blog_title}',blog_summary = '{$blog_summary}',post_per_page = $post_per_page,udpated_at = NOW() WHERE blog_id = $blog_id ";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function udpating_blog_with_image($blog_id,$blog_title,$blog_summary,$post_per_page,$path){
        $this->query = "UPDATE blog SET blog_title = '{$blog_title}',blog_summary = '{$blog_summary}',post_per_page = $post_per_page,blog_background_image = '{$path}',udpated_at = NOW() WHERE blog_id = $blog_id ";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }
    /*----Blog end ----*/    

    /*----Category start ----*/
    public function creating_category($category_title,$category_description){
        $this->query  = "INSERT INTO category(category_title,category_description,created_at)
                        VALUES('{$category_title}','{$category_description}',NOW())";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function categories(){
        $this->query  = "SELECT * FROM category WHERE status != 'Delete' ORDER BY category_id DESC";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function category_record($category_id){
        $this->query  = " SELECT * FROM category WHERE category_id = $category_id";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function updating_category($category_id,$category_title,$category_description){
        $this->query  = "UPDATE category SET category_title = '{$category_title}', category_description ='{$category_description}',updated_at = NOW() WHERE category_id = $category_id ";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result; 
    }

    public function category_status($category_id,$status){
        $this->query  = "UPDATE category SET status = '{$status}' WHERE category_id = $category_id";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function delete_category($category_id){
        $this->query  = "UPDATE category SET status = 'Delete' WHERE category_id = $category_id";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }
    /*----Category end----*/

    /*----Post start ----*/
    public function admin_blogs($user_id){
        $this->query  = "SELECT * FROM users u INNER JOIN blog b ON u.`user_id` = b.`user_id` WHERE b.`user_id` = $user_id";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;  
    }
    public function post_categories(){
        $this->query  = "SELECT * FROM category WHERE status = 'Active'";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function creating_post($blog_id,$post_title,$post_summary,$post_description,$path,$comments){
        $this->query  = "INSERT INTO post(blog_id,post_title,post_summary,post_description,featured_image,comments_status,created_at)
        VALUES($blog_id,'{$post_title}','{$post_summary}','{$post_description}','{$path}','{$comments}',NOW())";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result; 
    }

    public function creating_post_category($category_id,$post_id){
        $this->query  = "INSERT INTO post_category(category_id,post_id,created_at)
        VALUES($category_id,$post_id,NOW())";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function creating_post_attachments($post_id,$attachment_title,$path){
        $this->query  = "INSERT INTO attachment(post_id,post_attachment_title,post_attachment_path,created_at)
        VALUES($post_id,'{$attachment_title}','{$path}',NOW())";
        $this->result = mysqli_query($this->connection,$this->query);
        // $this->result = "SELECT LAST_INSERT_ID()";
        return $this->result;
    }

    public function sending_email($blog_id){
        $this->query  = "SELECT * FROM users u INNER JOIN follow f ON u.`user_id` = f.`user_id` 
        INNER JOIN blog b ON f.`blog_id` = b.`blog_id` WHERE f.`status` = 'Follow' AND f.`blog_id` = $blog_id";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }
    
    public function post($post_id){
        $this->query  = "SELECT * FROM post WHERE post_id = $post_id";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function post_record(){
        $this->query  = "SELECT * FROM post ORDER BY post_id DESC LIMIT 1";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function show_posts($user_id){
        $this->query = "SELECT * FROM users u INNER JOIN blog b ON u.`user_id` = b.`user_id` INNER JOIN post p ON b.`blog_id` = p.`blog_id` WHERE p.`status` != 'Delete' AND u.`user_id` = $user_id ORDER BY p.`post_id` DESC";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function post_status($post_id,$status){
        $this->query  = "UPDATE post SET status = '{$status}' WHERE post_id = $post_id";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function update_post_blog($post_id){
        $this->query  = "SELECT * FROM blog b INNER JOIN post p ON b.`blog_id` = p.`blog_id` WHERE p.`post_id` = $post_id";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function posts_attachments($post_id){
        $this->query  = "SELECT * FROM post p INNER JOIN attachment a ON p.`post_id` = a.`post_id` WHERE p.`post_id` = $post_id ORDER BY a.`attachment_id` DESC";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function add_more_categories($post_id){
        $this->query = "SELECT * FROM category WHERE STATUS = 'Active' 
        AND category_id NOT IN (SELECT pc.`category_id` FROM post p INNER JOIN post_category pc ON p.`post_id` = pc.`post_id`
        INNER JOIN category c ON pc.`category_id` = c.`category_id` WHERE p.`post_id` = $post_id)";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function posts_categories($post_id){
        $this->query  = "SELECT * FROM post p INNER JOIN post_category pc ON p.`post_id` = pc.`post_id`
        INNER JOIN category c ON pc.`category_id` = c.`category_id` WHERE p.`post_id` = $post_id ORDER BY p.`post_id` DESC";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;    
    }

    public function updating_post_with_image($blog_id,$post_id,$post_title,$post_summary,$post_description,$path,$comments){
        $this->query  = "UPDATE post SET blog_id = $blog_id, post_summary = '{$post_summary}',post_description = '{$post_description}',featured_image = '{$path}' ,comments_status = '{$comments}',udpated_at = NOW() WHERE post_id = $post_id";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function updating_post($blog_id,$post_id,$post_title,$post_summary,$post_description,$comments){
        $this->query  = "UPDATE post SET blog_id = $blog_id, post_title = '{$post_title}',  post_summary = '{$post_summary}',post_description = '{$post_description}',comments_status = '{$comments}',udpated_at = NOW() WHERE post_id = $post_id";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function post_category_status($post_id,$category_id,$status){
        $this->query  = "UPDATE post_category SET post_category_status = '{$status}',updated_at = NOW() WHERE post_id = $post_id AND category_id = $category_id";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result; 
    }

    public function post_attachment_status($attachment_id,$status){
        $this->query  = "UPDATE attachment SET status = '{$status}',updated_at = NOW() WHERE attachment_id = $attachment_id";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }
    /*----Post end ----*/


    /*----Setting Start ----*/
    public function user_profile($user_id){
        $this->query  = "SELECT * FROM users INNER JOIN role ON users.role_id = role.role_id WHERE users.user_id = $user_id";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function password_check($user_id,$old_password){
        $this->query  = "SELECT * FROM users WHERE PASSWORD = '{$old_password}' AND user_id = $user_id";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function change_password($user_id,$new_password){
        $this->query  = "UPDATE users SET password = '{$new_password}' WHERE user_id = $user_id";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result; 
    }

    public function admin_total_blogs($user_id){
        $this->query  = "SELECT COUNT(*) AS total_blogs FROM blog WHERE user_id = $user_id";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function admin_total_posts($user_id){
        $this->query = "SELECT COUNT(*) AS total_posts FROM users u INNER JOIN blog b ON u.user_id = b.user_id INNER JOIN post p ON b.blog_id = p.blog_id WHERE u.user_id = $user_id";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }
    
    public function update_profile($user_id,$first_name,$last_name,$gender,$address,$path){
        $this->query = "UPDATE users SET first_name = '{$first_name}',last_name='{$last_name}',gender='{$gender}',address='{$address}',profile_picture='{$path}',updated_at = NOW() WHERE user_id = $user_id";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }
    /*----Setting End ----*/


    /*----forgot password start ----*/
    public function forgot_password($email){
        $this->query  = "SELECT * FROM users WHERE email = '{$email}'";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }
    public function changing_password($user_id){
        $random = "Abcde".rand(1,2000);
        $this->query = "UPDATE users SET password = '{$random}' WHERE user_id = $user_id ";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }
    /*----forgot password end ----*/


    /*----feedback start ----*/
    public function show_feedbacks(){
        $this->query  = "SELECT * FROM feedback ORDER BY feedback_id DESC";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function feedback_user($user_id,$message){
        $query  = "SELECT * FROM users WHERE user_id = $user_id";
        $result = mysqli_query($this->connection,$query);
        $row    = mysqli_fetch_assoc($result); 
        $record = extract($row);
        $this->query = "INSERT INTO feedback(user_id,full_name,email,feedback)
        VALUES($user_id,'".$first_name." ".$last_name."','{$email}','{$message}')";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function feedback_visitor($full_name,$email,$message){
        $this->query  = "INSERT INTO feedback(full_name,email,feedback)
        VALUES('{$full_name}','{$email}','{$message}')";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function sending_email_to_admins(){
        $this->query  = "SELECT * FROM users WHERE role_id = 1";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }
    /*----feedback end ----*/


    /*---- Comments starts ----*/
    public function comments_count($post_id){
        $this->query  = "SELECT COUNT(*) AS 'comments_count' FROM post INNER JOIN post_comment ON post.`post_id` = post_comment.`post_id` WHERE post.`post_id` = $post_id";  
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function show_comments($post_id){
        $this->query  = "SELECT * FROM users INNER JOIN post_comment ON users.`user_id` = post_comment.`user_id`
        INNER JOIN post ON post_comment.`post_id` = post.`post_id` WHERE post.`post_id` = $post_id ORDER BY post_comment.`post_comment_id` DESC";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function post_comments_status($post_comment_id,$status){
        $this->query  = "UPDATE post_comment SET comment_status = '{$status}' WHERE post_comment_id = $post_comment_id";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }
    /*---- Comments starts ----*/






/*-------  website's starts  -------*/

    public function recent_posts(){
        $this->query  = "SELECT * FROM post INNER JOIN blog ON post.`blog_id` = blog.`blog_id` WHERE post.`status` = 'Active' ORDER BY post_id DESC LIMIT 5";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function recent_blogs(){
        $this->query  = "SELECT * FROM users INNER JOIN blog ON users.`user_id` = blog.`user_id` WHERE blog.status = 'Active' ORDER BY blog.`blog_id` DESC LIMIT 5";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function all_blogs($start,$per_page){
        $this->query  = "SELECT * FROM users INNER JOIN blog ON users.`user_id` = blog.`user_id` 
        WHERE blog.status = 'Active' ORDER BY blog.`blog_id` DESC LIMIT $start,$per_page";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function search_blogs($search){
        $this->query  = "SELECT * FROM users INNER JOIN blog ON users.`user_id` = blog.`user_id` 
        WHERE blog.`status` = 'Active' AND blog.`blog_title` LIKE '%{$search}%' OR users.`first_name` LIKE '%{$search}%'";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function search_posts($search,$blog_id){
        $this->query  = "SELECT * FROM blog INNER JOIN post ON blog.`blog_id` = post.`blog_id` 
        WHERE blog.`blog_id` = $blog_id AND post.`status` = 'Active' AND post.`post_title` LIKE '%{$search}%'";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }
    // public function blog_paggination(){
    // $this->query  = "SELECT COUNT(*) AS 'total_blogs' FROM users INNER JOIN blog ON users.`user_id` = blog.`user_id` WHERE blog.status = 'Active' ORDER BY blog.`blog_id`";
    // $this->result = mysqli_query($this->connection,$this->query);
    // return $this->result;   
    // }

    public function blog_page($blog_id){
        $this->query  = "SELECT * FROM users INNER JOIN blog ON blog.`user_id` = users.`user_id` WHERE blog.`blog_id` = $blog_id AND blog.`status` = 'Active' ORDER BY blog.`blog_id` DESC";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function total_blog_posts($blog_id){
        $this->query  = "SELECT COUNT(*) AS 'total_blog_posts' FROM blog INNER JOIN post ON blog.`blog_id` = post.`blog_id` 
        WHERE blog.`blog_id` = $blog_id AND post.`status` = 'Active'";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function total_blog_followers($blog_id){
        $this->query  = "SELECT COUNT(*) AS 'total_followers' FROM follow INNER JOIN blog ON follow.`blog_id` = blog.`blog_id` 
        WHERE blog.`blog_id` = $blog_id AND follow.`status` = 'Follow'";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function blogs_count(){
        $this->query  = "SELECT COUNT(*) AS 'total_blogs' FROM blog WHERE STATUS = 'Active'";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function blog_page_post($blog_id,$start,$per_page){
        $this->query  = "SELECT * FROM blog INNER JOIN post ON blog.`blog_id` = post.`blog_id` 
        WHERE blog.`blog_id` = $blog_id AND post.status = 'Active' ORDER BY post.`post_id` DESC LIMIT $start,$per_page";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function post_paggination($blog_id){
        $this->query  = "SELECT COUNT(*) AS 'total_posts' FROM blog INNER JOIN post ON blog.`blog_id` = post.`blog_id` 
        WHERE blog.`blog_id` = $blog_id AND post.status = 'Active'";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function blog_author($user_id,$blog_id){
        $this->query  = "SELECT * FROM users INNER JOIN blog ON users.`user_id` = blog.`user_id` WHERE users.`user_id` = $user_id AND blog.`blog_id` = $blog_id";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function follower_check($user_id,$blog_id){
        $this->query  = "SELECT follow.`status` AS follow_status FROM users INNER JOIN follow ON users.`user_id` = follow.`user_id` WHERE follow.`blog_id` = $blog_id AND users.`user_id` = $user_id";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function follow_status($user_id,$blog_id,$status){
        $this->query  = "UPDATE follow SET STATUS = '{$status}',updated_at = NOW() WHERE user_id = $user_id AND blog_id = $blog_id";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function new_follower($user_id,$blog_id){
        $this->query = "INSERT INTO follow(user_id,blog_id,status,created_at)
        VALUES($user_id,$blog_id,'Follow',NOW())";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function blog_page_post_categories($blog_id){
        $this->query  = "SELECT DISTINCT(category.`category_title`) AS categories FROM blog INNER JOIN post ON blog.`blog_id` = post.`blog_id`
        INNER JOIN post_category ON post.`post_id` = post_category.`post_id`
        INNER JOIN category ON post_category.`category_id` = category.`category_id`
        WHERE blog.`blog_id` = $blog_id  AND post_category.`post_category_status` = 'Active'";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function related_blogs($user_id,$blog_id){
        $this->query  = "SELECT * FROM users INNER JOIN blog ON users.`user_id` = blog.`user_id`
        WHERE blog.`status` = 'Active' AND users.`user_id` = $user_id AND blog.`blog_id` != $blog_id";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function related_posts($blog_id,$post_id){
        $this->query  = "SELECT * FROM users INNER JOIN blog ON users.`user_id` = blog.`user_id`
        INNER JOIN post ON blog.`blog_id` = post.`blog_id`
        WHERE blog.`blog_id` = $blog_id AND post.`post_id` != $post_id";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function blog_post($post_id){
        $this->query  = "SELECT * FROM users INNER JOIN blog ON users.`user_id` = blog.`user_id` 
        INNER JOIN post ON blog.`blog_id` = post.`blog_id` 
        WHERE post.`post_id` = $post_id";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function blog_post_attachment($post_id){
        $this->query  = "SELECT * FROM post INNER JOIN attachment ON post.`post_id` = attachment.`post_id` 
        WHERE post.`post_id` = $post_id AND attachment.`status` = 'Active' ORDER BY attachment.`attachment_id` DESC";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function commenting($user_id,$post_id,$comment){
        $this->query = "INSERT INTO post_comment(user_id,post_id,comment,created_at)
        VALUES($user_id,$post_id,'{$comment}',NOW())";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function author_commenting($author_id,$post_id,$comment){
        $this->query = "INSERT INTO post_comment(user_id,post_id,comment,comment_status,created_at)
        VALUES($author_id,$post_id,'{$comment}','Active',NOW())";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function all_comments($post_id){
        $this->query = "SELECT users.*,post_comment.* FROM post_comment INNER JOIN users ON users.`user_id` = post_comment.`user_id` 
        INNER JOIN post ON post_comment.`post_id` = post.`post_id` WHERE post.`post_id` = $post_id AND post_comment.`comment_status` = 'Active' ORDER BY post_comment.`post_comment_id` DESC";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function theme_settings($user_id,$key,$value){
        $this->query  = "INSERT INTO theme_setting(user_id,setting_key,setting_value,created_at)
        VALUES($user_id,'{$key}','{$value}',NOW())";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function user_theme_settings($user_id){
        $this->query  = "SELECT * FROM theme_setting INNER JOIN users ON theme_setting.user_id = users.`user_id` 
        WHERE theme_setting.`setting_status` = 'Active' AND users.`user_id` = $user_id";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function manage_theme_setting($user_id,$key){
        $this->query  = "SELECT * FROM theme_setting WHERE setting_key = '{$key}' AND user_id = $user_id";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
     }

    public function remove_theme_setting($user_id,$key){
        $this->query  = "DELETE FROM theme_setting WHERE user_id = 2 AND setting_key = '{$key}'";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }


    public function requesting_user($email){
        $this->query  = "SELECT * FROM users WHERE email = '{$email}'";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;
    }

    public function all_admins(){
        $this->query  = "SELECT * FROM users WHERE role_id = 1 AND status = 'Active'";
        $this->result = mysqli_query($this->connection,$this->query);
        return $this->result;  
    }
/*-------  website's ends  -------*/
}


?>