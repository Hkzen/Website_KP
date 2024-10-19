// server.cjs
const mysql = require('mysql');
const express = require('express');
const app = express();
const cors = require('cors');

app.use(cors());
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

const db = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'test-produk'
});

// Endpoint for searching products
app.get('/search', (req, res) => {
    const keyword = req.query.keyword;
    const sql = `SELECT * FROM produks WHERE nama_produk LIKE ?`;

    db.query(sql, [`%${keyword}%`], (err, result) => {
        if (err) {
            console.error("Database query error:", err); // Log the error
            return res.status(500).send('Database error'); // Send a 500 response
        }
        if (result.length === 0) {
            return res.send({ message: 'No products found.' });
        }
        res.send(result);
    });
});

// Endpoint for searching products with categories
app.get('/dashboard/produks/search', (req, res) => {
    const keyword = req.query.keyword; // Fetch the keyword from query parameters
    const sql = `
        SELECT p.*, k.nama AS kategori_nama 
        FROM produks p
        LEFT JOIN kategoris k ON p.kategori_id = k.id 
        WHERE p.nama_produk LIKE ?`;

    // Perform the database query
    db.query(sql, [`%${keyword}%`], (error, result) => {
        if (error) {
            console.error("Database query error:", error); // Log the error
            return res.status(500).send('Internal Server Error'); // Send a 500 response
        }
        
        // Send the result as a JSON response
        if (result.length === 0) {
            return res.send([]); // No results found
        }
        res.send(result); // Send the results back to the client
    });
});

// Start the server
app.listen(3000, () => {
    console.log('Server is running at port 3000');
});
