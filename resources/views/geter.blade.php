<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kirim & Uji Notifikasi Getar</title>
</head>

<body>
    <button onclick="triggerLocalVibrateNotification()">Kirim Notifikasi + Getar Sekarang</button>

    <script>
        function triggerLocalVibrateNotification() {
            // 1. Cek apakah browser mendukung Notifikasi & Service Worker
            if (!("Notification" in window)) {
                alert("Browser di HP ini tidak mendukung fitur Notifikasi Web.");
                return;
            }

            // 2. Jika izin belum ditentukan (default) atau sudah ditolak, minta izin dulu
            if (Notification.permission !== "granted") {
                Notification.requestPermission().then(function(permission) {
                    if (permission === "granted") {
                        // Izin berhasil diberikan, jalankan notifikasi
                        sendVibrateNotification();
                    } else {
                        alert("Izin notifikasi ditolak. Harap aktifkan izin di setelan browser HP Anda.");
                    }
                });
            } else {
                // Jika izin sudah diberikan sebelumnya
                sendVibrateNotification();
            }
        }

        function sendVibrateNotification() {
            navigator.serviceWorker.ready.then(function(registration) {
                registration.showNotification("PANGGILAN ANTRIAN MCU", {
                    body: "Bapak/Ibu Ahmad - Silahkan menuju Poli Pemeriksaan 1",
                    icon: "https://via.placeholder.com/128",
                    vibrate: [500, 200, 500, 200, 800],
                    renotify: true,
                    tag: 'mcu-antrian'
                });
            });
        }
    </script>
</body>

</html>
