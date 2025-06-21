const fs = require('fs');
const path = require('path');

class WhatsAppConfig {
    constructor() {
        this.configPath = path.join(__dirname, 'whatsapp-config.json');
        this.config = this.loadConfig();
    }

    // Memuat konfigurasi dari file
    loadConfig() {
        try {
            if (fs.existsSync(this.configPath)) {
                const data = fs.readFileSync(this.configPath, 'utf8');
                return JSON.parse(data);
            }
        } catch (error) {
            console.error('Error loading WhatsApp config:', error);
        }
        return this.getDefaultConfig();
    }

    // Menyimpan konfigurasi ke file
    saveConfig(config) {
        try {
            fs.writeFileSync(this.configPath, JSON.stringify(config, null, 2));
            this.config = config;
            return true;
        } catch (error) {
            console.error('Error saving WhatsApp config:', error);
            return false;
        }
    }

    // Konfigurasi default
    getDefaultConfig() {
        return {
            enabled: false,
            token: '',
            phoneNumber: '',
            templates: {
                newComplaint: '🔔 *PENGADUAN BARU*\n\nID: {id}\nNama: {nama}\nTanggal: {tanggal}\nKategori: {kategori}\nLokasi: {lokasi}',
                statusUpdate: '📝 *UPDATE STATUS PENGADUAN*\n\nID: {id}\nStatus: {status}\nUpdate: {tanggal_update}\nCatatan: {catatan}',
                complaintResolved: '✅ *PENGADUAN SELESAI*\n\nID: {id}\nNama: {nama}\nTanggal Selesai: {tanggal_selesai}\nKesimpulan: {kesimpulan}'
            },
            notifications: {
                newComplaint: true,
                statusUpdate: true,
                complaintResolved: true
            }
        };
    }

    // Update konfigurasi
    updateConfig(newConfig) {
        const updatedConfig = { ...this.config, ...newConfig };
        return this.saveConfig(updatedConfig);
    }

    // Mendapatkan template pesan
    getTemplate(type) {
        return this.config.templates[type] || '';
    }

    // Mengecek apakah notifikasi diaktifkan
    isNotificationEnabled(type) {
        return this.config.enabled && this.config.notifications[type];
    }

    // Mendapatkan nomor telepon
    getPhoneNumber() {
        return this.config.phoneNumber;
    }

    // Mendapatkan token
    getToken() {
        return this.config.token;
    }
}

module.exports = WhatsAppConfig; 