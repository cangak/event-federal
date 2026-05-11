<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Scan Barcode
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Scan QR participant untuk mengisi registered, CP1, CP2, atau finish time.
                </p>
            </div>

            <a
                href="{{ route('admin.participants.index') }}"
                class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"
            >
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto grid max-w-7xl gap-6 px-4 sm:px-6 lg:grid-cols-[1.1fr_0.9fr] lg:px-8">
            <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <form id="scan-form" action="{{ route('admin.participants.check-in') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <div class="mb-3 flex items-center justify-between gap-3">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200">
                                Pilih Mode Scan
                            </label>
                            <span id="checkpoint-label" class="rounded-full bg-teal-100 px-3 py-1 text-xs font-bold text-teal-700 dark:bg-teal-500/15 dark:text-teal-300">
                                Registrasi
                            </span>
                        </div>

                        <input id="checkpoint" name="checkpoint" type="hidden" value="registered_at">

                        <div class="grid grid-cols-2 gap-3">
                            <button
                                type="button"
                                data-checkpoint="registered_at"
                                data-label="Registrasi"
                                class="checkpoint-button min-h-24 rounded-lg border-2 border-teal-600 bg-teal-600 px-4 py-5 text-center text-xl font-black text-white shadow-lg shadow-teal-600/20 transition hover:bg-teal-700 focus:outline-none focus:ring-4 focus:ring-teal-500/25"
                            >
                                Registrasi
                            </button>
                            <button
                                type="button"
                                data-checkpoint="cp1_at"
                                data-label="CP1"
                                class="checkpoint-button min-h-24 rounded-lg border-2 border-gray-200 bg-white px-4 py-5 text-center text-xl font-black text-gray-800 shadow-sm transition hover:border-sky-500 hover:bg-sky-50 focus:outline-none focus:ring-4 focus:ring-sky-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:hover:border-sky-400 dark:hover:bg-sky-500/10"
                            >
                                CP1
                            </button>
                            <button
                                type="button"
                                data-checkpoint="cp2_at"
                                data-label="CP2"
                                class="checkpoint-button min-h-24 rounded-lg border-2 border-gray-200 bg-white px-4 py-5 text-center text-xl font-black text-gray-800 shadow-sm transition hover:border-orange-500 hover:bg-orange-50 focus:outline-none focus:ring-4 focus:ring-orange-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:hover:border-orange-400 dark:hover:bg-orange-500/10"
                            >
                                CP2
                            </button>
                            <button
                                type="button"
                                data-checkpoint="finished_at"
                                data-label="Finish"
                                class="checkpoint-button min-h-24 rounded-lg border-2 border-gray-200 bg-white px-4 py-5 text-center text-xl font-black text-gray-800 shadow-sm transition hover:border-emerald-500 hover:bg-emerald-50 focus:outline-none focus:ring-4 focus:ring-emerald-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:hover:border-emerald-400 dark:hover:bg-emerald-500/10"
                            >
                                Finish
                            </button>
                        </div>
                    </div>

                    <div class="overflow-hidden rounded-lg bg-gray-950">
                        <video id="scanner-video" class="aspect-video w-full object-cover" muted playsinline></video>
                        <div id="html5-reader" class="hidden min-h-72 bg-gray-950"></div>
                    </div>

                    <div id="scanner-status" class="rounded-lg bg-gray-100 px-4 py-3 text-sm font-medium text-gray-600 dark:bg-gray-900 dark:text-gray-300">
                        Camera scanner siap dinyalakan.
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2">
                        <button
                            type="button"
                            id="start-camera"
                            class="rounded-lg bg-teal-600 px-5 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-teal-700 focus:outline-none focus:ring-4 focus:ring-teal-500/20"
                        >
                            Start Camera
                        </button>
                        <button
                            type="button"
                            id="stop-camera"
                            class="rounded-lg border border-gray-300 bg-white px-5 py-3 text-sm font-bold text-gray-700 shadow-sm transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 dark:hover:bg-gray-700"
                        >
                            Stop Camera
                        </button>
                    </div>

                    <div class="border-t border-gray-200 pt-5 dark:border-gray-700">
                        <label for="token" class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">
                            Manual QR Token
                        </label>
                        <div class="flex flex-col gap-3 sm:flex-row">
                            <input
                                id="token"
                                name="token"
                                type="text"
                                value="{{ old('token') }}"
                                placeholder="Paste token QR jika camera tidak tersedia"
                                class="min-h-11 flex-1 rounded-lg border-gray-300 text-sm shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                            >
                            <button
                                type="submit"
                                class="rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-bold text-white transition hover:bg-gray-700 dark:bg-gray-100 dark:text-gray-900 dark:hover:bg-white"
                            >
                                Submit Scan
                            </button>
                        </div>

                        @error('token')
                            <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror

                        <div class="mt-5 rounded-lg border border-dashed border-gray-300 p-4 dark:border-gray-700">
                            <label for="qr-file" class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-200">
                                Upload Screenshot QR
                            </label>
                            <input
                                id="qr-file"
                                type="file"
                                accept="image/*"
                                class="block w-full text-sm text-gray-600 file:mr-4 file:rounded-lg file:border-0 file:bg-teal-600 file:px-4 file:py-2.5 file:text-sm file:font-bold file:text-white hover:file:bg-teal-700 dark:text-gray-300"
                            >
                            <p class="mt-2 text-xs leading-5 text-gray-500 dark:text-gray-400">
                                Gunakan ini kalau kamera browser diblokir. Ambil foto atau screenshot QR, lalu upload di sini.
                            </p>
                        </div>
                    </div>
                </form>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <h3 class="text-lg font-bold text-gray-950 dark:text-white">Scan Result</h3>
                <div id="scan-result" class="mt-4 rounded-lg border border-dashed border-gray-300 p-5 text-sm text-gray-500 dark:border-gray-700 dark:text-gray-400">
                    Hasil scan akan tampil di sini.
                </div>
            </div>
        </div>
    </div>

    <script>
        const video = document.getElementById('scanner-video');
        const form = document.getElementById('scan-form');
        const tokenInput = document.getElementById('token');
        const checkpointInput = document.getElementById('checkpoint');
        const checkpointLabel = document.getElementById('checkpoint-label');
        const checkpointButtons = document.querySelectorAll('.checkpoint-button');
        const statusBox = document.getElementById('scanner-status');
        const resultBox = document.getElementById('scan-result');
        const startButton = document.getElementById('start-camera');
        const stopButton = document.getElementById('stop-camera');
        const qrFileInput = document.getElementById('qr-file');

        let stream = null;
        let detector = null;
        let html5Scanner = null;
        let scannerMode = null;
        let scanning = false;
        let lastToken = '';
        let lastScanAt = 0;

        const inactiveCheckpointClass = 'checkpoint-button min-h-24 rounded-lg border-2 border-gray-200 bg-white px-4 py-5 text-center text-xl font-black text-gray-800 shadow-sm transition hover:border-teal-500 hover:bg-teal-50 focus:outline-none focus:ring-4 focus:ring-teal-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:hover:border-teal-400 dark:hover:bg-teal-500/10';
        const activeCheckpointClass = 'checkpoint-button min-h-24 rounded-lg border-2 border-teal-600 bg-teal-600 px-4 py-5 text-center text-xl font-black text-white shadow-lg shadow-teal-600/20 transition hover:bg-teal-700 focus:outline-none focus:ring-4 focus:ring-teal-500/25';

        function setStatus(message, tone = 'neutral') {
            const tones = {
                neutral: 'rounded-lg bg-gray-100 px-4 py-3 text-sm font-medium text-gray-600 dark:bg-gray-900 dark:text-gray-300',
                success: 'rounded-lg bg-emerald-100 px-4 py-3 text-sm font-medium text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300',
                error: 'rounded-lg bg-red-100 px-4 py-3 text-sm font-medium text-red-700 dark:bg-red-500/15 dark:text-red-300',
            };

            statusBox.className = tones[tone] || tones.neutral;
            statusBox.textContent = message;
        }

        function extractToken(value) {
            try {
                const url = new URL(value);
                const parts = url.pathname.split('/').filter(Boolean);
                return parts.pop() || value;
            } catch (error) {
                return value.trim();
            }
        }

        function selectCheckpoint(button) {
            checkpointInput.value = button.dataset.checkpoint;
            checkpointLabel.textContent = button.dataset.label;
            checkpointButtons.forEach((item) => {
                item.className = item === button ? activeCheckpointClass : inactiveCheckpointClass;
            });
            setStatus(`Mode scan: ${button.dataset.label}. Arahkan kamera ke QR participant.`);
        }

        function cameraErrorMessage(error) {
            if (! window.isSecureContext) {
                return 'Camera diblokir karena halaman tidak dibuka lewat HTTPS atau localhost. Pakai HTTPS/ngrok/Valet secure, atau gunakan upload screenshot QR/manual token.';
            }

            if (! navigator.mediaDevices || ! navigator.mediaDevices.getUserMedia) {
                return 'Browser ini tidak menyediakan akses kamera. Gunakan upload screenshot QR atau input manual token.';
            }

            if (error.name === 'NotAllowedError' || error.name === 'PermissionDeniedError') {
                return 'Permission kamera ditolak. Izinkan akses kamera di browser, lalu refresh halaman.';
            }

            if (error.name === 'NotFoundError' || error.name === 'DevicesNotFoundError') {
                return 'Kamera tidak ditemukan di device ini. Gunakan upload screenshot QR atau input manual token.';
            }

            if (error.name === 'NotReadableError' || error.name === 'TrackStartError') {
                return 'Kamera sedang dipakai aplikasi lain. Tutup aplikasi kamera lain, lalu coba lagi.';
            }

            if (error.name === 'OverconstrainedError' || error.name === 'ConstraintNotSatisfiedError') {
                return 'Kamera belakang tidak tersedia. Saya akan coba kamera default.';
            }

            return 'Camera tidak bisa diakses. Pastikan permission browser diizinkan, atau gunakan upload screenshot QR.';
        }

        async function getCameraStream() {
            try {
                return await navigator.mediaDevices.getUserMedia({
                    video: { facingMode: { ideal: 'environment' } },
                    audio: false,
                });
            } catch (error) {
                if (error.name !== 'OverconstrainedError' && error.name !== 'ConstraintNotSatisfiedError') {
                    throw error;
                }

                return navigator.mediaDevices.getUserMedia({
                    video: true,
                    audio: false,
                });
            }
        }

        function renderResult(data, tone = 'success') {
            const participant = data.participant || {};
            const alertClass = tone === 'error'
                ? 'border-red-200 bg-red-50 text-red-700 dark:border-red-500/30 dark:bg-red-500/10 dark:text-red-300'
                : data.already_scanned
                    ? 'border-amber-200 bg-amber-50 text-amber-700 dark:border-amber-500/30 dark:bg-amber-500/10 dark:text-amber-300'
                    : 'border-emerald-200 bg-emerald-50 text-emerald-700 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-300';

            resultBox.className = `mt-4 rounded-lg border p-5 text-sm ${alertClass}`;
            resultBox.innerHTML = `
                <div class="font-bold">${data.message}</div>
                ${participant.name ? `
                    <div class="mt-4 grid gap-3 text-gray-700 dark:text-gray-200">
                        <div>
                            <div class="text-xs font-semibold uppercase tracking-wide opacity-70">Participant</div>
                            <div class="font-bold">${participant.bib_number} - ${participant.name}</div>
                            <div class="text-xs opacity-75">${participant.community || '-'}</div>
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <div>Registered: <strong>${participant.registered_at || '-'}</strong></div>
                            <div>CP1: <strong>${participant.cp1_at || '-'}</strong></div>
                            <div>CP2: <strong>${participant.cp2_at || '-'}</strong></div>
                            <div>Finish: <strong>${participant.finished_at || '-'}</strong></div>
                        </div>
                    </div>
                ` : ''}
            `;
        }

        async function submitToken(rawToken) {
            const token = extractToken(rawToken);
            const now = Date.now();

            if (! token) {
                setStatus('Token QR kosong.', 'error');
                return;
            }

            if (token === lastToken && now - lastScanAt < 3000) {
                return;
            }

            lastToken = token;
            lastScanAt = now;
            tokenInput.value = token;
            setStatus('Mengirim hasil scan...', 'neutral');

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                    },
                    body: JSON.stringify({
                        token,
                        checkpoint: checkpointInput.value,
                    }),
                });

                const data = await response.json();

                if (! response.ok) {
                    throw new Error(data.message || 'Scan gagal diproses.');
                }

                setStatus(data.message, data.already_scanned ? 'neutral' : 'success');
                renderResult(data);
            } catch (error) {
                setStatus(error.message, 'error');
                renderResult({ message: error.message }, 'error');
            }
        }

        async function scanLoop() {
            if (! scanning || ! detector) {
                return;
            }

            try {
                const barcodes = await detector.detect(video);

                if (barcodes.length > 0) {
                    await submitToken(barcodes[0].rawValue);
                }
            } catch (error) {
                setStatus('Scanner belum bisa membaca frame kamera.', 'error');
            }

            requestAnimationFrame(scanLoop);
        }

        async function startCamera() {
            await stopCamera();

            if ('BarcodeDetector' in window) {
                await startNativeCamera();
                return;
            }

            await startHtml5Camera();
        }

        async function startNativeCamera() {
            detector = new BarcodeDetector({ formats: ['qr_code'] });

            try {
                stream = await getCameraStream();

                scannerMode = 'native';
                document.getElementById('html5-reader').classList.add('hidden');
                video.classList.remove('hidden');
                video.srcObject = stream;
                await video.play();
                scanning = true;
                setStatus('Camera aktif. Arahkan ke QR participant.', 'success');
                scanLoop();
            } catch (error) {
                setStatus(cameraErrorMessage(error), 'error');
            }
        }

        async function startHtml5Camera() {
            if (! window.Html5Qrcode) {
                setStatus('Fallback QR scanner belum termuat. Jalankan npm run build lalu refresh halaman.', 'error');
                return;
            }

            try {
                if (! window.isSecureContext) {
                    setStatus(cameraErrorMessage(new Error('Insecure context')), 'error');
                    return;
                }

                scannerMode = 'html5';
                video.classList.add('hidden');
                document.getElementById('html5-reader').classList.remove('hidden');

                html5Scanner = new window.Html5Qrcode('html5-reader', {
                    formatsToSupport: [window.Html5QrcodeSupportedFormats.QR_CODE],
                    verbose: false,
                });

                await html5Scanner.start(
                    { facingMode: 'environment' },
                    { fps: 10, qrbox: { width: 260, height: 260 } },
                    (decodedText) => submitToken(decodedText),
                    () => {}
                );

                scanning = true;
                setStatus('Camera aktif dengan fallback scanner. Arahkan ke QR participant.', 'success');
            } catch (error) {
                setStatus(cameraErrorMessage(error), 'error');
            }
        }

        async function scanQrFile(file) {
            if (! file) {
                return;
            }

            if (! window.Html5Qrcode) {
                setStatus('QR file scanner belum termuat. Jalankan npm run build lalu refresh halaman.', 'error');
                return;
            }

            await stopCamera();

            const reader = document.getElementById('html5-reader');
            video.classList.add('hidden');
            reader.classList.remove('hidden');
            setStatus('Membaca QR dari gambar...', 'neutral');

            const fileScanner = new window.Html5Qrcode('html5-reader', {
                formatsToSupport: [window.Html5QrcodeSupportedFormats.QR_CODE],
                verbose: false,
            });

            try {
                const decodedText = await fileScanner.scanFile(file, true);
                await submitToken(decodedText);
                setStatus('QR dari gambar berhasil dibaca.', 'success');
            } catch (error) {
                setStatus('QR tidak terbaca dari gambar. Pastikan gambar jelas dan QR tidak terpotong.', 'error');
            }
        }

        async function stopCamera() {
            scanning = false;

            if (stream) {
                stream.getTracks().forEach((track) => track.stop());
                stream = null;
            }

            if (html5Scanner && scannerMode === 'html5') {
                try {
                    await html5Scanner.stop();
                    await html5Scanner.clear();
                } catch (error) {
                    // Scanner may already be stopped by the browser.
                }

                html5Scanner = null;
            }

            video.srcObject = null;
            scannerMode = null;
            setStatus('Camera scanner dihentikan.');
        }

        startButton.addEventListener('click', startCamera);
        stopButton.addEventListener('click', stopCamera);
        checkpointButtons.forEach((button) => {
            button.addEventListener('click', () => selectCheckpoint(button));
        });
        qrFileInput.addEventListener('change', (event) => {
            scanQrFile(event.target.files[0]);
        });

        form.addEventListener('submit', (event) => {
            if (! tokenInput.value.trim()) {
                return;
            }

            event.preventDefault();
            submitToken(tokenInput.value);
        });
    </script>
</x-app-layout>
