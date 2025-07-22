<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>签到系统</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#165DFF',
            secondary: '#FF7D00',
            success: '#00B42A',
            warning: '#FF7D00',
            danger: '#F53F3F',
            dark: '#1D2129',
            light: '#F2F3F5'
          },
          fontFamily: {
            inter: ['Inter', 'system-ui', 'sans-serif'],
          },
        },
      }
    }
  </script>
  <style type="text/tailwindcss">
    @layer utilities {
      .content-auto {
        content-visibility: auto;
      }
      .card-shadow {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      }
      .btn-hover {
        @apply transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5;
      }
      .form-input-focus {
        @apply focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all;
      }
    }
  </style>
</head>
<body class="font-inter bg-gray-50 text-dark min-h-screen flex flex-col">
  <!-- 全局状态管理 -->
  <script>
    // 模拟数据库
    const db = {
      users: [
        { id: 1, username: 'admin', password: 'Admin123', name: '管理员', points: 0, isAdmin: true },
        { id: 2, username: 'user1', password: 'User123', name: '张三', points: 100, isAdmin: false },
        { id: 3, username: 'user2', password: 'User456', name: '李四', points: 50, isAdmin: false }
      ],
      products: [
        { id: 1, name: '保温杯', points: 50, quantity: 10, description: '304不锈钢真空保温杯，保温时长12小时以上。' },
        { id: 2, name: '充电宝', points: 80, quantity: 5, description: '20000mAh大容量充电宝，支持快充。' },
        { id: 3, name: '蓝牙音箱', points: 120, quantity: 3, description: '高品质蓝牙音箱，360°环绕立体声。' },
        { id: 4, name: '无线耳机', points: 150, quantity: 0, description: '主动降噪无线耳机，续航30小时。' }
      ],
      checkins: [
        { userId: 2, date: '2025-07-20' },
        { userId: 3, date: '2025-07-21' }
      ],
      passwordRequests: [],
      exchangeRequests: []
    };

    // 全局状态
    const state = {
      currentUser: null,
      currentPage: 'login', // login, register, forgotPassword, userDashboard, adminDashboard, productList, productDetail, adminProductList, adminAddProduct, adminEditProduct
      currentProduct: null,
      passwordRequest: { name: '', newPassword: '', confirmPassword: '' },
      productForm: { id: null, name: '', points: '', quantity: '', description: '' }
    };

    // 工具函数
    function saveDB() {
      localStorage.setItem('checkInSystemDB', JSON.stringify(db));
    }

    function loadDB() {
      const savedDB = localStorage.getItem('checkInSystemDB');
      if (savedDB) {
        Object.assign(db, JSON.parse(savedDB));
      }
    }

    function validatePassword(password) {
      return /^[A-Za-z0-9]+$/.test(password);
    }

    function validateUsername(username) {
      return /^[A-Za-z0-9]+$/.test(username);
    }

    function validateChineseName(name) {
      return /^[\u4e00-\u9fa5]+$/.test(name);
    }

    function formatDate(date) {
      const d = new Date(date);
      return `${d.getFullYear()}-${(d.getMonth() + 1).toString().padStart(2, '0')}-${d.getDate().toString().padStart(2, '0')}`;
    }

    function hasCheckedInToday(userId) {
      const today = formatDate(new Date());
      return db.checkins.some(checkin => checkin.userId === userId && checkin.date === today);
    }

    // 页面导航
    function navigateTo(page) {
      state.currentPage = page;
      render();
    }

    // 用户认证
    function handleRegister() {
      const username = document.getElementById('register-username').value.trim();
      const password = document.getElementById('register-password').value;
      const confirmPassword = document.getElementById('register-confirm-password').value;

      if (!username || !password || !confirmPassword) {
        showToast('请填写所有字段', 'error');
        return;
      }

      if (!validateUsername(username)) {
        showToast('用户名只能包含大小写字母和数字', 'error');
        return;
      }

      if (db.users.some(user => user.username === username)) {
        showToast('用户名已存在', 'error');
        return;
      }

      if (password !== confirmPassword) {
        showToast('两次输入的密码不一致', 'error');
        return;
      }

      if (!validatePassword(password)) {
        showToast('密码只能包含大小写字母和数字', 'error');
        return;
      }

      const newUser = {
        id: db.users.length > 0 ? Math.max(...db.users.map(user => user.id)) + 1 : 1,
        username,
        password,
        name: username,
        points: 0,
        isAdmin: false
      };

      db.users.push(newUser);
      saveDB();
      showToast('注册成功，请登录', 'success');
      navigateTo('login');
    }

    function handleLogin() {
      const us
