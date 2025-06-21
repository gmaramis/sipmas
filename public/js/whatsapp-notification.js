const axios = require('axios');

class WhatsAppNotification {
    constructor(token) {
        this.token = token;
        this.baseUrl = 'https://api.fontewa.com/api/v1';
    }

    async sendMessage(phone, message) {
        try {
            // Format nomor telepon (hapus +62 atau 0 di awal)
            const formattedPhone = phone.replace(/^(\+62|0)/, '62');
            
            const response = await axios.post(`${this.baseUrl}/send-message`, {
                phone: formattedPhone,
                message: message
            }, {
                headers: {
                    'Authorization': `Bearer ${this.token}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });

            if (response.data.success) {
                console.log('Pesan berhasil dikirim:', response.data);
                return true;
            } else {
                console.error('Gagal mengirim pesan:', response.data);
                return false;
            }
        } catch (error) {
            console.error('Error mengirim pesan:', error.response ? error.response.data : error.message);
            throw new Error('Gagal mengirim pesan WhatsApp: ' + (error.response ? error.response.data.message : error.message));
        }
    }

    async sendNewComplaintNotification(phone, complaintData) {
        const message = `🔔 *PENGADUAN BARU*\n\n` +
            `ID: ${complaintData.id}\n` +
            `Judul: ${complaintData.title}\n` +
            `Kategori: ${complaintData.category}\n` +
            `Lokasi: ${complaintData.location}\n` +
            `Status: Menunggu Verifikasi\n\n` +
            `Silakan login ke dashboard admin untuk memproses pengaduan ini.`;

        return this.sendMessage(phone, message);
    }

    async sendStatusUpdateNotification(phone, complaintData) {
        const message = `📝 *UPDATE STATUS PENGADUAN*\n\n` +
            `ID: ${complaintData.id}\n` +
            `Judul: ${complaintData.title}\n` +
            `Status: ${complaintData.status}\n` +
            `Update: ${complaintData.update}\n\n` +
            `Silakan cek status pengaduan Anda di aplikasi SIPMAS.`;

        return this.sendMessage(phone, message);
    }

    async sendResolvedNotification(phone, complaintData) {
        const message = `✅ *PENGADUAN SELESAI*\n\n` +
            `ID: ${complaintData.id}\n` +
            `Judul: ${complaintData.title}\n` +
            `Status: Selesai\n` +
            `Tanggal Selesai: ${complaintData.resolvedDate}\n` +
            `Catatan: ${complaintData.notes}\n\n` +
            `Terima kasih telah menggunakan layanan SIPMAS.`;

        return this.sendMessage(phone, message);
    }
}

module.exports = WhatsAppNotification; 