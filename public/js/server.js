const express = require('express');
const http = require('http');
const { Server } = require('socket.io');
const cors = require('cors');
const bodyParser = require('body-parser');
const path = require('path');
const whatsappRouter = require('./whatsapp-api');
require('dotenv').config();

const app = express();
const server = http.createServer(app);
const io = new Server(server, {
    cors: {
        origin: "*", // Dalam produksi, ganti dengan domain yang spesifik
        methods: ["GET", "POST"]
    }
});

// Middleware
app.use(cors());
app.use(bodyParser.json());
app.use(express.static(path.join(__dirname, 'public')));

// Simpan koneksi admin yang aktif
const activeAdmins = new Set();

// Socket.IO Connection Handler
io.on('connection', (socket) => {
    console.log('Client terhubung:', socket.id);

    // Handler untuk admin yang login
    socket.on('admin_login', () => {
        activeAdmins.add(socket.id);
        console.log('Admin terhubung:', socket.id);
    });

    // Handler untuk admin yang logout
    socket.on('admin_logout', () => {
        activeAdmins.delete(socket.id);
        console.log('Admin terputus:', socket.id);
    });

    // Handler untuk pengaduan baru
    socket.on('new_complaint', (data) => {
        // Kirim notifikasi ke semua admin yang aktif
        activeAdmins.forEach(adminId => {
            io.to(adminId).emit('new_complaint', {
                id: data.id,
                pelapor: data.pelapor,
                jenis: data.jenis,
                waktu: new Date().toISOString()
            });
        });
    });

    // Handler untuk disconnect
    socket.on('disconnect', () => {
        activeAdmins.delete(socket.id);
        console.log('Client terputus:', socket.id);
    });
});

// API Routes
app.post('/api/complaints', (req, res) => {
    const { pelapor, jenis, deskripsi } = req.body;
    
    // Simulasi ID unik untuk pengaduan
    const complaintId = Date.now().toString();
    
    // Data pengaduan
    const complaintData = {
        id: complaintId,
        pelapor,
        jenis,
        deskripsi,
        waktu: new Date().toISOString()
    };

    // Kirim notifikasi ke semua admin yang aktif
    activeAdmins.forEach(adminId => {
        io.to(adminId).emit('new_complaint', complaintData);
    });

    res.json({
        success: true,
        message: 'Pengaduan berhasil diterima',
        data: complaintData
    });
});

// Endpoint untuk mengecek status server
app.get('/api/status', (req, res) => {
    res.json({
        status: 'online',
        activeAdmins: activeAdmins.size,
        timestamp: new Date().toISOString()
    });
});

// Routes
app.use('/api/whatsapp', whatsappRouter);

// Serve static files
app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, 'index.html'));
});

app.get('/admin', (req, res) => {
    res.sendFile(path.join(__dirname, 'admin.html'));
});

app.get('/pengaturan', (req, res) => {
    res.sendFile(path.join(__dirname, 'pengaturan.html'));
});

// Error handling
app.use((err, req, res, next) => {
    console.error(err.stack);
    res.status(500).json({ error: 'Terjadi kesalahan pada server' });
});

// Jalankan server
const PORT = process.env.PORT || 3000;
server.listen(PORT, () => {
    console.log(`Server berjalan di port ${PORT}`);
}); 