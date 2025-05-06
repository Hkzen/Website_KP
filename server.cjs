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
    const keyword = req.query.keyword || ''; // Search keyword
    const page = parseInt(req.query.page) || 1; // Current page
    const limit = 6; // Number of products per page
    const offset = (page - 1) * limit; // Calculate offset

    const sql = `
        SELECT 
            p.*,
            COALESCE(AVG(pr.rating), 0) as avg_rating,
            COUNT(pr.id) as comment_count,
            (COALESCE(AVG(pr.rating), 0) * 0.7 + COUNT(pr.id) * 0.3) as weight
        FROM produks p
        LEFT JOIN product_review pr ON p.id = pr.produk_id
        WHERE p.nama_produk LIKE ? OR p.deskripsi_produk LIKE ?
        GROUP BY p.id
        ORDER BY weight DESC
        LIMIT ? OFFSET ?
    `;

    db.query(sql, [`%${keyword}%`, `%${keyword}%`, limit, offset], (err, result) => {
        if (err) {
            console.error("Database query error:", err);
            return res.status(500).json({ html: '<p class="text-danger">Error sistem</p>', hasMore: false });
        }

        if (result.length === 0) {
            return res.json({ products: [], hasMore: false, currentPage: page, keyword: keyword });
        }

        res.json({
            products: result,
            hasMore: result.length === limit,
            currentPage: page,
            keyword: keyword
        });
    });
});
// Start the server
app.listen(3000, () => {
    console.log('Server is running at port 3000');
});