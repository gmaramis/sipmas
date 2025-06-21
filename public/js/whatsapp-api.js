const express = require('express');
const router = express.Router();
const WhatsAppConfig = require('./whatsapp-config');
const WhatsAppNotification = require('./whatsapp-notification');

const whatsappConfig = new WhatsAppConfig();

// Mendapatkan konfigurasi WhatsApp
router.get('/config', (req, res) => {
    try {
        const config = whatsappConfig.config;
        // Menyembunyikan API key dari response
        const safeConfig = { ...config, apiKey: config.apiKey ? '********' : '' };
        res.json(safeConfig);
    } catch (error) {
        res.status(500).json({ error: 'Gagal mengambil konfigurasi WhatsApp' });
    }
});

// Update konfigurasi WhatsApp
router.post('/config', (req, res) => {
    try {
        const { enabled, apiKey, phoneNumber, templates, notifications } = req.body;
        
        // Validasi input
        if (apiKey && apiKey.length < 10) {
            return res.status(400).json({ error: 'API key tidak valid' });
        }
        
        if (phoneNumber && !phoneNumber.match(/^\d{10,15}$/)) {
            return res.status(400).json({ error: 'Nomor telepon tidak valid' });
        }

        const newConfig = {
            enabled: enabled ?? whatsappConfig.config.enabled,
            apiKey: apiKey || whatsappConfig.config.apiKey,
            phoneNumber: phoneNumber || whatsappConfig.config.phoneNumber,
            templates: templates || whatsappConfig.config.templates,
            notifications: notifications || whatsappConfig.config.notifications
        };

        const success = whatsappConfig.updateConfig(newConfig);
        if (success) {
            res.json({ message: 'Konfigurasi WhatsApp berhasil diperbarui' });
        } else {
            res.status(500).json({ error: 'Gagal menyimpan konfigurasi WhatsApp' });
        }
    } catch (error) {
        res.status(500).json({ error: 'Gagal memperbarui konfigurasi WhatsApp' });
    }
});

// Test koneksi WhatsApp
router.post('/test', async (req, res) => {
    try {
        const { phoneNumber } = req.body;
        const apiKey = whatsappConfig.getApiKey();

        if (!apiKey) {
            return res.status(400).json({ error: 'API key belum dikonfigurasi' });
        }

        const whatsapp = new WhatsAppNotification(apiKey);
        const testMessage = '🔔 *TEST NOTIFIKASI SIPMAS*\n\nIni adalah pesan test untuk memverifikasi konfigurasi WhatsApp.';

        await whatsapp.sendMessage(phoneNumber, testMessage);
        res.json({ message: 'Pesan test berhasil dikirim' });
    } catch (error) {
        res.status(500).json({ error: 'Gagal mengirim pesan test' });
    }
});

module.exports = router; 