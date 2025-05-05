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
            return res.json({ html: '<p class="text-muted">Produk tidak ditemukan</p>', hasMore: false }); // No products found
        }

        const html = result.map(product => `
            <div class="col-md-4 mb-3">
                <div class="card h-100" style="border-color:rgb(86, 91, 227); border-width: 5px; box-shadow: rgba(86, 91, 227, 0.355) 0px 4px 8px 0px;">
                    <img src="/storage/${product.foto_produk}" class="card-img-top" alt="${product.nama_produk}">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="/produk/${product.id}" style="color: rgb(86, 91, 227);">
                                ${product.nama_produk}
                            </a>
                        </h5>
                        <p>${product.excerpt || ''}</p>
                        <p>
                            <strong>Rating: </strong>
                            ${Array.from({ length: 5 }, (_, i) => 
                                i < Math.floor(product.avg_rating) ? 
                                '★' : '☆'
                            ).join('')}
                            (${product.avg_rating.toFixed(1)})
                        </p>
                    </div>
                </div>
            </div>
        `).join('');

        res.json({ html, hasMore: result.length === limit }); // Check if there are more products
    });
});

// Start the server
app.listen(3000, () => {
    console.log('Server is running at port 3000');
});