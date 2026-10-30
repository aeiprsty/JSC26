import './bootstrap';

window.Echo.channel('klaster-updates')
    .listen('.status.updated', (e) => {
        console.log('Klaster diperbarui:', e.klaster);
        // Tambahkan logika untuk reload data tabel/peta otomatis di sini
        location.reload(); 
    });