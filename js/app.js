lucide.createIcons();

function getDepth() {
    return window.location.pathname.includes('/jadwal_angkut') || 
           window.location.pathname.includes('/iuran_warga') || 
           window.location.pathname.includes('/laporan') || 
           window.location.pathname.includes('/edukasi') || 
           window.location.pathname.includes('/dokumentasi') ||
           window.location.pathname.includes('/auth') ? '../' : '';
}

window.addEventListener('DOMContentLoaded', () => {
    const isLoggedIn = localStorage.getItem('sipas_auth');
    const depth = getDepth();
    const isAuthPage = window.location.pathname.includes('/auth/');
    
    // Hanya redirect ke login jika belum login DAN sedang berada di luar folder auth
    if (!isLoggedIn && !isAuthPage) {
        window.location.href = depth + 'auth/index.php';
    }
});

function handleLogout() {
    window.location.href = getDepth() + 'auth/logout.php';
}

function showToast(message, type = 'info') {
    const container = document.getElementById('toast-container');
    if(!container) return;
    
    const toast = document.createElement('div');
    let bgClass = 'bg-slate-800 text-white';
    let icon = 'info';
    
    if (type === 'success') { bgClass = 'bg-emerald-600 text-white'; icon = 'check-circle'; } 
    else if (type === 'error') { bgClass = 'bg-red-500 text-white'; icon = 'alert-octagon'; }

    toast.className = `px-4 py-3 rounded-xl shadow-xl text-sm font-medium ${bgClass} transition-all duration-300 transform translate-y-[-20px] opacity-0 flex items-center gap-2`;
    toast.innerHTML = `<i data-lucide="${icon}" class="w-5 h-5 shrink-0"></i> <span>${message}</span>`;
    
    container.appendChild(toast);
    lucide.createIcons();

    setTimeout(() => toast.classList.remove('translate-y-[-20px]', 'opacity-0'), 10);
    setTimeout(() => {
        toast.classList.add('opacity-0', 'translate-y-[-20px]');
        setTimeout(() => toast.remove(), 300);
    }, 3500);
}

function openModal(modalId) {
    const modalOverlay = document.getElementById('modal-overlay');
    if(!modalOverlay) return;
    document.getElementById('modal-qris').classList.add('hidden');
    document.getElementById('modal-dana').classList.add('hidden');
    
    const target = document.getElementById(modalId);
    target.classList.remove('hidden');
    target.classList.remove('scale-100');
    target.classList.add('scale-95');

    modalOverlay.classList.remove('hidden');
    modalOverlay.classList.add('flex');
    
    setTimeout(() => {
        modalOverlay.classList.remove('opacity-0');
        target.classList.remove('scale-95');
        target.classList.add('scale-100');
    }, 10);
}

function closeModal() {
    const modalOverlay = document.getElementById('modal-overlay');
    if(!modalOverlay) return;
    modalOverlay.classList.add('opacity-0');
    document.getElementById('modal-qris').classList.remove('scale-100');
    document.getElementById('modal-qris').classList.add('scale-95');
    document.getElementById('modal-dana').classList.remove('scale-100');
    document.getElementById('modal-dana').classList.add('scale-95');
    
    setTimeout(() => {
        modalOverlay.classList.add('hidden');
        modalOverlay.classList.remove('flex');
        document.getElementById('modal-qris').classList.add('hidden');
        document.getElementById('modal-dana').classList.add('hidden');
    }, 300);
}

function simulatePayment(method) {
    closeModal();
    setTimeout(() => {
        showToast(`Pembayaran iuran berhasil via ${method}!`, 'success');
    }, 400);
}

function handleDanaPayment(e) {
    e.preventDefault();
    const phone = document.getElementById('dana-phone').value;
    if(phone) {
        simulatePayment('DANA');
        document.getElementById('dana-phone').value = '';
    }
}

function submitReport(e) {
    e.preventDefault();
    document.getElementById('form-laporan').reset();
    showToast('Laporan berhasil dikirim ke pengurus RT!', 'success');
}

// --- FUNGSI JAM REAL-TIME ---
function updateRealtimeClock() {
    const dateElement = document.getElementById('realtime-date');
    const clockElement = document.getElementById('realtime-clock');

    if (!dateElement || !clockElement) return;

    const now = new Date();

    const hariList = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const bulanList = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

    const hari = hariList[now.getDay()];
    const tanggal = now.getDate();
    const bulan = bulanList[now.getMonth()];
    const tahun = now.getFullYear();

    const jam = String(now.getHours()).padStart(2, '0');
    const menit = String(now.getMinutes()).padStart(2, '0');
    const detik = String(now.getSeconds()).padStart(2, '0');

    dateElement.textContent = `${hari}, ${tanggal} ${bulan} ${tahun}`;
    clockElement.textContent = `${jam}:${menit}:${detik} WIB`;
}

setInterval(updateRealtimeClock, 1000);
document.addEventListener('DOMContentLoaded', updateRealtimeClock);