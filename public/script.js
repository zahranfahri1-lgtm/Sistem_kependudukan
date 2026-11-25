// Konfirmasi hapus
document.querySelectorAll('a.hapus').forEach(btn => {
  btn.addEventListener('click', e => {
    if (!confirm('Yakin ingin menghapus data penduduk ini?')) e.preventDefault();
  });
});

// === Premium custom cursor (tanpa helm) ===
const cursorDot = document.createElement('div');
const cursorOutline = document.createElement('div');

cursorDot.className = 'cursor-dot';
cursorOutline.className = 'cursor-outline';
document.body.appendChild(cursorDot);
document.body.appendChild(cursorOutline);

let mouseX = 0, mouseY = 0;
let outlineX = 0, outlineY = 0;

document.addEventListener('mousemove', e => {
  mouseX = e.clientX;
  mouseY = e.clientY;

  cursorDot.style.left = mouseX + 'px';
  cursorDot.style.top = mouseY + 'px';
});

// Smooth follow for outline
function animateOutline() {
  const dx = mouseX - outlineX;
  const dy = mouseY - outlineY;
  outlineX += dx * 0.2;
  outlineY += dy * 0.2;

  cursorOutline.style.left = outlineX + 'px';
  cursorOutline.style.top = outlineY + 'px';

  // Parallax gerak elemen dengan data-parallax
  document.querySelectorAll('[data-parallax]').forEach(el => {
    const speed = parseFloat(el.getAttribute('data-parallax')) || 0.05;
    const x = (mouseX - window.innerWidth / 2) * speed;
    const y = (mouseY - window.innerHeight / 2) * speed;
    el.style.transform = `translate(${x}px, ${y}px)`;
  });

  requestAnimationFrame(animateOutline);
}
animateOutline();

// Hover effect on interactive elements
const hoverables = document.querySelectorAll('a, button, input, select, .btn');

hoverables.forEach(el => {
  el.addEventListener('mouseenter', () => {
    cursorOutline.classList.add('hovered');
    cursorOutline.classList.toggle('no-blur', el.classList.contains('island-hotspot'));
    cursorDot.style.transform = 'translate(-50%, -50%) scale(0.6)';
    cursorDot.style.background = 'var(--purple-light)';
  });
  el.addEventListener('mouseleave', () => {
    cursorOutline.classList.remove('hovered');
    cursorOutline.classList.remove('no-blur');
    cursorDot.style.transform = 'translate(-50%, -50%) scale(1)';
    cursorDot.style.background = 'var(--purple)';
  });
});

// Hide cursor when leaving window
document.addEventListener('mouseleave', () => {
  cursorOutline.style.opacity = '0';
  cursorDot.style.opacity = '0';
});
document.addEventListener('mouseenter', () => {
  cursorOutline.style.opacity = '1';
  cursorDot.style.opacity = '1';
});

// Open the native date picker when any part of the date field is clicked.
document.querySelectorAll('input[type="date"]').forEach(input => {
  input.addEventListener('click', () => {
    if (typeof input.showPicker === 'function') {
      try { input.showPicker(); } catch (error) { /* Picker may already be open. */ }
    }
  });
});

// Toggle kota extra rows handled in populasi.php inline script

// === Efek ombak/ripple saat klik di halaman data ===
document.addEventListener('click', e => {
  if (!e.currentTarget || !e.currentTarget.getBoundingClientRect) return;
  
  const ripple = document.createElement('div');
  ripple.className = 'ripple';
  const rect = e.currentTarget.getBoundingClientRect();
  const size = Math.max(rect.width, rect.height);
  ripple.style.width = size + 'px';
  ripple.style.height = size + 'px';
  ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
  ripple.style.top = (e.clientY - rect.top - size / 2) + 'px';
  e.currentTarget.appendChild(ripple);
  setTimeout(() => ripple.remove(), 600);
});

// Smooth fade between pages on this site; normal browser behavior stays for external links.
(function() {
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

  window.addEventListener('pageshow', () => {
    document.body.classList.remove('page-leaving');
    if (!reduceMotion.matches) {
      document.body.classList.add('page-entering');
      window.setTimeout(() => document.body.classList.remove('page-entering'), 360);
    }
  });

  document.addEventListener('click', event => {
    if (event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey || reduceMotion.matches) return;
    const link = event.target.closest('a[href]');
    if (!link || link.hasAttribute('download') || (link.target && link.target !== '_self')) return;

    const destination = new URL(link.href, window.location.href);
    if (destination.origin !== window.location.origin) return;
    if (destination.pathname === window.location.pathname && destination.search === window.location.search && destination.hash) return;
    if (destination.href === window.location.href) return;

    event.preventDefault();
    document.body.classList.add('page-leaving');
    window.setTimeout(() => { window.location.href = destination.href; }, 260);
  });
})();

// Admin command palette: find residents or jump to common pages/actions.
(function() {
  const dialog = document.getElementById('commandPalette');
  if (!dialog) return;

  const input = document.getElementById('commandSearch');
  const results = document.getElementById('commandResults');
  const pages = [
    { title: 'Tambah warga baru', description: 'Buka formulir tambah data', href: 'index.php#form-tambah', keywords: 'buat tambah warga data penduduk' },
    { title: 'Data warga', description: 'Lihat dan kelola daftar penduduk', href: 'index.php', keywords: 'daftar warga penduduk home' },
    { title: 'Statistik', description: 'Lihat ringkasan data penduduk', href: 'stats.php', keywords: 'statistik grafik jumlah' },
    { title: 'Peta Indonesia', description: 'Lihat sebaran populasi', href: 'populasi.php', keywords: 'peta wilayah populasi' },
    { title: 'Import data', description: 'Impor data penduduk', href: 'import.php', keywords: 'import unggah csv' },
    { title: 'Audit log', description: 'Lihat riwayat perubahan data', href: 'audit.php', keywords: 'audit riwayat aktivitas' },
    { title: 'Kelola admin', description: 'Buka pengaturan akun admin', href: 'admin.php', keywords: 'akun pengguna admin' }
  ];
  let activeIndex = 0;

  function renderCommands() {
    const query = input.value.trim();
    const normalized = query.toLocaleLowerCase('id');
    const tokens = normalized.split(/\s+/).filter(Boolean);
    const commands = pages.filter(page => {
      const searchable = `${page.title} ${page.description} ${page.keywords}`.toLocaleLowerCase('id');
      return !tokens.length || tokens.every(token => searchable.includes(token));
    });

    if (query) {
      const rtMatch = query.match(/\b(?:di\s*)?RT\s*0*(\d{1,3})\b/i);
      const searchQuery = rtMatch ? query.replace(rtMatch[0], '').replace(/\bdi\b/ig, '').trim() : query;
      const rtNumber = rtMatch ? rtMatch[1].padStart(3, '0') : '';
      const searchParams = new URLSearchParams();
      if (searchQuery) searchParams.set('search', searchQuery);
      if (rtMatch) searchParams.set('rt_rw', rtNumber);
      commands.push({
        title: rtMatch ? `Cari ${searchQuery || 'warga'} di RT ${rtNumber}` : `Cari warga: ${query}`,
        description: rtMatch ? 'Cari nama/NIK sekaligus filter RT' : 'Cari berdasarkan nama atau NIK di daftar warga',
        href: `index.php?${searchParams.toString()}`
      });
      const digits = query.replace(/\D/g, '');
      if (digits.length >= 4 && digits.length <= 16) {
        commands.push({
          title: `Cari KK: ${digits}`,
          description: 'Filter daftar dengan nomor Kartu Keluarga',
          href: `index.php?nomor_kk=${encodeURIComponent(digits)}`
        });
      }
    }

    results.replaceChildren();
    activeIndex = 0;
    if (!commands.length) {
      const empty = document.createElement('p');
      empty.className = 'command-empty';
      empty.textContent = 'Tidak ada halaman yang cocok. Tekan Enter untuk mencari warga.';
      results.appendChild(empty);
      return;
    }

    commands.slice(0, 8).forEach((command, index) => {
      const button = document.createElement('button');
      button.type = 'button';
      button.className = 'command-option';
      button.setAttribute('role', 'option');
      button.setAttribute('aria-selected', index === activeIndex ? 'true' : 'false');
      const title = document.createElement('strong');
      title.textContent = command.title;
      const description = document.createElement('span');
      description.textContent = command.description;
      button.append(title, description);
      button.addEventListener('mouseenter', () => setActive(index));
      button.addEventListener('click', () => {
        dialog.close();
        window.location.href = command.href;
      });
      results.appendChild(button);
    });
  }

  function setActive(index) {
    const options = [...results.querySelectorAll('.command-option')];
    if (!options.length) return;
    activeIndex = (index + options.length) % options.length;
    options.forEach((option, optionIndex) => option.setAttribute('aria-selected', optionIndex === activeIndex ? 'true' : 'false'));
    options[activeIndex].scrollIntoView({ block: 'nearest' });
  }

  function openPalette() {
    if (!dialog.open) dialog.showModal();
    input.value = '';
    renderCommands();
    window.setTimeout(() => input.focus(), 0);
  }

  input.addEventListener('input', renderCommands);
  input.addEventListener('keydown', event => {
    if (event.key === 'ArrowDown') { event.preventDefault(); setActive(activeIndex + 1); }
    if (event.key === 'ArrowUp') { event.preventDefault(); setActive(activeIndex - 1); }
    if (event.key === 'Enter') {
      event.preventDefault();
      results.querySelector('.command-option[aria-selected="true"]')?.click();
      if (!results.querySelector('.command-option')) {
        window.location.href = `index.php?search=${encodeURIComponent(input.value.trim())}`;
      }
    }
  });
  dialog.addEventListener('click', event => {
    if (event.target === dialog) dialog.close();
  });
  document.addEventListener('keydown', event => {
    if ((event.ctrlKey || event.metaKey) && event.key.toLowerCase() === 'k') {
      event.preventDefault();
      openPalette();
    }
  });
  renderCommands();
})();
