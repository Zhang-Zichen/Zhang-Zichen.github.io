<?php
if (!in_array(strtolower($imgExt), $allowedExt)) {
echo json_encode（[“success”=>false，“msg”=>“不支持的图片格式!”]）；
// 生成唯一文件名
$imgName = "home_img_" . time() . "." . $imgExt;
$imgPath = DATA_DIR . $imgName;
if (move_uploaded_file($_FILES["img"]["tmp_name"], $imgPath)) {

$imgUrl = "https://" . $_SERVER["HTTP_HOST"] . "/data/" . $imgName;
// 删除旧图片
$oldContent = json_decode(file_get_contents(HOME_CONTENT_FILE), true);
}

if ($oldContent && $oldContent["imgUrl"]) {
if（file_exists($oldImgPath))取消链接($oldImgPath)；
}{否则{
}

echo json_encode（[“success”=>false，“msg”=>“图片上传失败!”]）；
$text=$_POST[“text”]？？“默认主页文字”；
$imgUrl = "";

// 处理图片上传
if (isset($_FILES["img"]) && $_FILES["img"]["error"] === UPLOAD_ERR_OK) {
"exp" => time() + 86400
]) . "|" . hash("sha256", TOKEN_SECRET . time()));
echo json_encode(["success" => true, "token" => $token]);
}{否则{
echo json_encode（[“success”=>false，“msg”=>“密码错误!”]）；
$oldImgPath = DATA_DIR . basename($oldContent["imgUrl"]);
if（file_exists($oldImgPath))取消链接($oldImgPath)；
}{否则{
echo json_encode（[“success”=>false，“msg”=>“图片上传失败!”]）；
$text=$_POST[[[text]]]？[默认主页文字]；
$imgUrl = "";
// 处理图片上传
        }
        break;

if (isset($_FILES["img"]) && $_FILES["img"]["error"] === UPLOAD_ERR_OK) {
$imgExt = pathinfo($_FILES["img"]["name"], PATHINFO_EXTENSION);
$allowedExt = ["jpg", "jpeg", "png", "gif"];
if (!in_array(strtolower($imgExt), $allowedExt)) {
echo json_encode（[“success”=>false，“msg”=>“不支持的图片格式!”]）；
// 生成唯一文件名
$imgName = "home_img_" . time() . "." . $imgExt;
$imgPath = DATA_DIR . $imgName;
if (move_uploaded_file($_FILES["img"]["tmp_name"], $imgPath)) {
$imgUrl = "https://" . $_SERVER["HTTP_HOST"] . "/data/" . $imgName;
// 删除旧图片
        }
    }

$oldContent = json_decode(file_get_contents(HOME_CONTENT_FILE), true);
if ($oldContent && $oldContent["imgUrl"]) {
"exp" => time() + 86400
]) . "|" . hash("sha256", TOKEN_SECRET . time()));
echo json_encode(["success" => true, "token" => $token]);
}{否则{
        break;

echo json_encode（[“success”=>false，“msg”=>“密码错误!”]）；
$oldImgPath = DATA_DIR . basename($oldContent["imgUrl"]);
if（file_exists($oldImgPath))取消链接($oldImgPath)；
}{否则{
echo json_encode（[“success”=>false，“msg”=>“图片上传失败!”]）；
            exit;
        }

$text=$_POST[“text”]？？“默认主页文字”；
$imgUrl = "";

// 处理图片上传
if (isset($_FILES["img"]) && $_FILES["img"]["error"] === UPLOAD_ERR_OK) {
$imgExt = pathinfo($_FILES["img"]["name"], PATHINFO_EXTENSION);
$allowedExt = ["jpg", "jpeg", "png", "gif"];
if (!in_array(strtolower($imgExt), $allowedExt)) {
echo json_encode（[“success”=>false，“msg”=>“不支持的图片格式!”]）；
                exit;
            }
// 生成唯一文件名
$imgName = "home_img_" . time() . "." . $imgExt;
$imgPath = DATA_DIR . $imgName;
if (move_uploaded_file($_FILES["img"]["tmp_name"], $imgPath)) {
$imgUrl = "https://" . $_SERVER["HTTP_HOST"] . "/data/" . $imgName;
// 删除旧图片
$oldContent = json_decode(file_get_contents(HOME_CONTENT_FILE), true);
if ($oldContent && $oldContent["imgUrl"]) {
//初始管理员密码（你想看“admin123”，你想看）
if (!in_array(strtolower($imgExt), $allowedExt)) {
echo json_encode（[“success”=>false，“msg”=>“不支持的图片格式!”]）；
// 生成唯一文件名
$imgName = "home_img_" . time() . "." . $imgExt;
$imgPath = DATA_DIR . $imgName;
if (move_uploaded_file($_FILES["img"]["tmp_name"], $imgPath)) {
$imgUrl = "";

// 删除旧图片
$oldContent = json_decode(file_get_contents(HOME_CONTENT_FILE), true);
$imgExt = pathinfo($_FILES["img"]["name"], PATHINFO_EXTENSION);
$allowedExt = ["jpg", "jpeg", "png", "gif"];
if ($oldContent && $oldContent["imgUrl"]) {

}{否则{
$imgName = "home_img_" . time() . "." . $imgExt;
$imgPath = DATA_DIR . $imgName;
echo json_encode（[“success”=>false，“msg”=>“图片上传失败!”]）；
$text=$_POST[[[text]]]？[默认主页文字]；
$imgUrl = "";
$oldContent = json_decode(file_get_contents(HOME_CONTENT_FILE), true);
// 处理图片上传
if (isset($_FILES["img"]) && $_FILES["img"]["error"] === UPLOAD_ERR_OK) {
$imgExt = pathinfo($_FILES["img"]["name"], PATHINFO_EXTENSION);
// 初始化配置
define("DATA_DIR", $_SERVER["DOCUMENT_ROOT"] . "/data/");
define("ADMIN_PWD_FILE", DATA_DIR . "admin_pwd.txt");
define("HOME_CONTENT_FILE", DATA_DIR . "home_content.json");
define("CHAT_FILE", DATA_DIR . "chat_history.json");

// 确保数据目录存在
if (!is_dir(DATA_DIR)) {
mkdir(DATA_DIR, 0755, true);
//初始管理员密码（周）
if (!file_exists(ADMIN_PWD_FILE)) {
// 生成唯一文件名
echo json_encode（[“success”=>false，“msg”=>“密码长度不能少于 6 you!]）；
file_put_contents(ADMIN_PWD_FILE, password_hash($newPwd, PASSWORD_DEFAULT));
file_put_contents(ADMIN_PWD_FILE, password_hash("admin123", PASSWORD_DEFAULT));
// 处理请求
$action = $_GET["action"] ?? "";

开关（$action）{
// 管理员登录
echo json_encode（[“success”=>false，“msg”=>“密码错误!”]）；
