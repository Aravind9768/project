<?php 
if(!isset($_SESSION))
    session_start();
include_once("../config.php");
$GLOBALS["__LEVEL"]= 1;
include_once("../includes/membervalidation.php");
$user = array();
if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])) {
$conn = connect();
$id = mysqli_real_escape_string($conn,$_REQUEST['id']);
    $data = mysqli_query($conn,"select * from user where user_id=".$id." and access_level>0 limit 1");
    if(mysqli_num_rows($data)<=0) {
        die("User doesn't exist or you are not authorized to view this user's details");
    }
    while($row = mysqli_fetch_assoc($data)) {
        $user = $row;
    }
disconnect($conn);
}
?>
<div><form name="addUpdateUserForm" method="post" action="<?php echo $config['site']; ?>">
<div class="onecol"><table border="0" cellpadding="5" cellspacing="0" class="fullwidth">
<tr><td>Full Name</td><td><input type="text" name="full_name" id="full_name" class="fullwidth" 
    value="<?php echo !empty($user['full_name']) ? $user['full_name'] : ''; ?>"></td></tr>
<tr><td>Email ID</td><td><input type="text" name="email_id" id="email_id" class="fullwidth" 
    value="<?php echo !empty($user['email_id']) ? $user['email_id'] : ''; ?>"></td></tr>
<tr><td>Username</td><td><input type="text" name="username" id="username" class="fullwidth" 
    value="<?php echo !empty($user['username']) ? $user['username'] : ''; ?>"></td></tr>
<tr><td>Password</td><td><input type="password" name="password" id="password" class="fullwidth" 
    value="<?php echo !empty($user['password']) ? $user['password'] : ''; ?>"></td></tr>
<?php if(!isset($_REQUEST['id']) || $_SESSION['user']['user_id']!=$_REQUEST['id']) { 
    ?>
<tr><td>Type</td><td>
    <select name="access_level" id="access_level" class="fullwidth">
        <option value="1"<?php echo !empty($user['access_level']) && $user['access_level']=="1" ? ' selected ="selected"' : ''; ?>>Admin</option>
        <option value="2"<?php echo !empty($user['access_level']) && $user['access_level']=="2" ? ' selected ="selected"' : ''; ?>>End User</option>
    </select> 
</td></tr> 
<tr><td>Active</td><td><input type="checkbox" name="active_in" id="active_in" value="1"<?php echo isset($user['active_in']) && $user['active_in']=='1' ? ' checked="true"' : ''; ?>></td></tr>

<?php
}  
?>
<tr><td colspan="2" style="text-align:right">
    <input type="hidden" name="user_id" id="user_id" value="<?php echo !empty($user['user_id']) ? $user['user_id'] : ''; ?>">
    <input type="button" value="Save" onclick="javascript:addUpdateUser(window.event);" /></td></tr>
</table>
</div>

<div class="clear"></div>
</form></div>