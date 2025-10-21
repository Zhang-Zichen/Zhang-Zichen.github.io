<?php
// 配置
define("CONFIG_PATH", "data/config.json"); // 存储密码和主页内容配置
define("UPLOAD_DIR", "data/"); // 图片上传目录
define("SALT", "infinityfree_salt_2024"); // 密码加密盐值（可自定义修改）

// 初始化配置文件（首次运行自动创建）
function initConfig() {
    if (!file_exists(CONFIG_PATH)) {
        $defaultConfig = [
            "admin_password" => encryptPwd("admin123"), // 默认初始密码：admin123
            "home_content" => [
                "text" => "欢迎来到樱花公园站相关网站！",
                "img_url" => ""
            ]
        ];
        file_put_contents(CONFIG_PATH, json_encode($defaultConfig));
        return $defaultConfig;
    }
    return json_decode(file_get_contents(CONFIG_PATH), true);
}

// 密码加密（MD5+盐值，适配简单场景）
function encryptPwd($pwd) {
    return md5($pwd . SALT);
}

// 响应JSON格式数据
function response($success, $msg = "", $data = []) {
    header("Content-Type: application/json");
    echo json_encode(["success" => $success, "msg" => $msg, "data" => $data]);
    exit;
}

// 处理跨域（InfinityFree可能需要）
header("Access-Control-Allow-Origin: *");
$config = initConfig();
$action = $_GET["action"] ?? "";

// 1. 管理员登录
if ($action === "login") {
    $userPwd = $_POST["password"] ?? "";
    $encryptedPwd = encryptPwd($userPwd);
    
    if ($encryptedPwd === $config["admin_password"]) {
        // 简单会话管理（InfinityFree支持会话）
        session_start();
        $_SESSION["admin_login"] = true;
        response(true);
    } else {
        response(false, "密码错误！");
    }
}

// 2. 获取主页内容
if ($action === "getHomeContent") {
    response(true, "", $config["home_content"]);
}

// 3. 上传主页内容（需管理员登录）
if ($action === "uploadContent") {
    session_start();
    if (!isset($_SESSION["admin_login"]) || !$_SESSION["admin_login"]) {
        response(false, "请先登录管理员！");
    }

    $newText = $_POST["text"] ?? "";
    $newImgUrl = $config["home_content"]["img_url"];

    // 处理图片上传
    if (isset($_FILES["img"]) && $_FILES["img"]["error"] === UPLOAD_ERR_OK) {
        $imgName = uniqid() . "." . pathinfo($_FILES["img"]["name"], PATHINFO_EXTENSION);
        $imgPath = UPLOAD_DIR . $imgName;
        
        // 移动上传文件（InfinityFree的public_html目录下可写）
        if (move_uploaded_file($_FILES["img"]["tmp_name"], $imgPath)) {
            // 获取图片URL（InfinityFree主机域名+路径）
            $newImgUrl = "https://" . $_SERVER["HTTP_HOST"] . "/" . $imgPath;
        } else {
            response(false, "图片上传失败！");
        }
    }

    // 更新配置
    $config["home_content"] = ["text" => $newText, "img_url" => $newImgUrl];
    file_put_contents(CONFIG_PATH, json_encode($config));
    response(true, "内容保存成功！");
}

// 4. 修改管理员密码
if ($action === "changePwd") {
    session_start();
    if (!isset($_SESSION["admin_login"]) || !$_SESSION["admin_login"]) {
        response(false, "请先登录管理员！");
    }

    $newPwd = $_POST["newPwd"] ?? "";
    if (empty($newPwd)) {
        response(false, "新密码不能为空！");
    }

    $config["admin_password"] = encryptPwd($newPwd);
    file_put_contents(CONFIG_PATH, json_encode($config));
    response(true, "密码修改成功！");
}

// 默认响应
response(false, "无效的操作！");
