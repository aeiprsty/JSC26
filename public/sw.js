// Service Worker Sederhana - Cache dimatikan selama development
self.addEventListener('install', (event) => {
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    event.waitUntil(clients.claim());
});

self.addEventListener('fetch', (event) => {
    // Meneruskan seluruh request langsung ke jaringan tanpa caching
    event.respondWith(fetch(event.request));
});