<style media="screen">
  .pagination a{
    color: black;
    float: left;
    padding:5px 16px;
    text-decoration: none;
    transition: background-color .3s;
  }
  .pagination a:hover:not(.active){background-color: #ddd;}
</style>
<?php
    $query = "select * from posts";
    $result = mysqli_query($con,$query);
    $total_posts=0;
    while($row = mysqli_fetch_array($result)){
      $privacy = $row['privacy'];
      $uid = $_SESSION['uid'];
      $posterId = $row['posterId'];
      if($privacy=="private"){
        $friends="select from friends where uid='$uid' AND friendId = '$posterId' OR uid='$posterId' AND friendId = '$uid'";
        $friend_query = mysqli_query($con,$friends);
        if(isset($friend_query)){
          $total_posts++;
        }
      }elseif (strcasecmp($privacy,"public")==0) {
        $total_posts++;
      }
    }
    $total_pages = ceil($total_posts/$per_page);
    echo"
        <center>
            <div class='pagination'>
                <a href='home.php?page=1'>First Page</a>
    ";
    for ($i=1; $i <=$total_pages; $i++) {
      echo"<a href='home.php?page=$i'>$i</a>";
    }
    echo "<a href='home.php?page=$total_pages'>Last Page</a>
            </div>
        </center>
    ";
 ?>
