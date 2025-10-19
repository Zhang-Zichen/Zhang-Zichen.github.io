const express = require('express');
const bodyParser = require('body-parser');
const mysql = require('mysql2');
const path = require('path');
const { v4: uuidv4 } = require('uuid');
const dbConfig = require('./db.js');

const app = express();
const PORT = process.env.PORT || 3000;
const ADMIN_PASSWORD = process.env.ADMIN_PASSWORD || 'admin123';

// 连接数据库
const db = mysql.createConnection(dbConfig);
db.connect(err => {
  if (err) throw err;
  // 初始化数据表（首次运行自动创建）
  db.query(`
    CREATE TABLE IF NOT EXISTS homepage (
      id INT AUTO_INCREMENT PRIMARY KEY,
      title VARCHAR(255) NOT NULL,
      imageUrl TEXT,
      content TEXT
    )
  `, () => {
    // 插入默认主页数据（若表为空）
    db.query('SELECT * FROM homepage', (err, res) => {
      if (res.length === 0) {
        db.query(`
          INSERT INTO homepage (title, imageUrl, content)
          VALUES ('欢迎来到宁波市樱花公园站', 'https://via.placeholder.com/800x400?text=樱花公园站', '管理员可在后台修改文字和图片链接')
        `);
      }
    });
  });
  // 创建留言表
  db.query(`
    CREATE TABLE IF NOT EXISTS messages (
      id VARCHAR(50) PRIMARY KEY,
      name VARCHAR(100) NOT NULL,
      content TEXT NOT NULL,
      time BIGINT NOT NULL
    )
  `);
});

// 中间件
app.use(bodyParser.json());
app.use(express.static(path.join(__dirname, '.')));

// 管理员登录接口
app.post('/api/admin/login', (req, res) => {
  res.json({ success: req.body.password === ADMIN_PASSWORD });
});

// 主页内容接口（获取+保存）
app.get('/api/homepage', (req, res) => {
  db.query('SELECT * FROM homepage LIMIT 1', (err, data) => {
    res.json(data[0] || {});
  });
});
app.post('/api/homepage', (req, res) => {
  const { title, imageUrl, content } = req.body;
  db.query(`
    UPDATE homepage SET title=?, imageUrl=?, content=? WHERE id=1
  `, [title, imageUrl, content], (err) => {
    res.json({ success: !err });
  });
});

// 留言接口（获取+添加+删除）
app.get('/api/messages', (req, res) => {
  db.query('SELECT * FROM messages ORDER BY time DESC', (err, data) => {
    res.json(data);
  });
});
app.post('/api/messages', (req, res) => {
  const { name, content } = req.body;
  const id = uuidv4();
  db.query(`
    INSERT INTO messages (id, name, content, time)
    VALUES (?, ?, ?, ?)
  `, [id, name, content, Date.now()], (err) => {
    res.json({ success: !err });
  });
});
app.delete('/api/messages/:id', (req, res) => {
  db.query('DELETE FROM messages WHERE id=?', [req.params.id], (err) => {
    res.json({ success: !err });
  });
});

app.listen(PORT, () => {
  console.log(`Server running on port ${PORT}`);
});
