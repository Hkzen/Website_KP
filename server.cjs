// server.js
// Dalam server.js atau app.js
const mysql = require('mysql');
const express = require('express');
const app = express();

const db = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'test-produk'
});

// Dalam server.js atau app.js
app.get('/search', (req, res) => {
  let keyword = req.query.keyword;
  let sql = `SELECT * FROM produks WHERE nama_produk LIKE ?`;
  db.query(sql, [`%${keyword}%`], (err, result) => {
      if (err) throw err;
      if (result.length === 0) {
          res.send({message: 'No products found.'});
      } else {
          res.send(result);
      }
  });
});

app.listen(3000, () => {
    console.log('Server is running at port 3000');
});
