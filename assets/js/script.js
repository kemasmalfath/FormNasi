// Script untuk validasi form dan interaksi
document.addEventListener("DOMContentLoaded", () => {
  // Validasi form donasi
  const form = document.querySelector(".donation-form")
  if (form) {
    form.addEventListener("submit", (e) => {
      const jumlahDonasi = document.getElementById("jumlah_donasi").value
      const jenisDonasi = document.getElementById("jenis_donasi").value

      // Validasi jumlah donasi minimum
      if (Number.parseInt(jumlahDonasi) < 1000) {
        e.preventDefault()
        alert("Jumlah donasi minimal Rp 1.000")
        return false
      }

      // Validasi jenis donasi
      if (!jenisDonasi) {
        e.preventDefault()
        alert("Silakan pilih jenis donasi")
        return false
      }

      // Konfirmasi sebelum submit
      if (!confirm("Apakah data yang Anda masukkan sudah benar?")) {
        e.preventDefault()
        return false
      }
    })
  }

  // Format input jumlah donasi
  const jumlahInput = document.getElementById("jumlah_donasi")
  if (jumlahInput) {
    jumlahInput.addEventListener("input", function () {
      // Hapus karakter non-digit
      this.value = this.value.replace(/[^0-9]/g, "")
    })
  }

  // Preview file upload
  const fileInput = document.getElementById("bukti_transfer")
  if (fileInput) {
    fileInput.addEventListener("change", function () {
      const file = this.files[0]
      if (file) {
        // Validasi ukuran file (5MB)
        if (file.size > 5 * 1024 * 1024) {
          alert("Ukuran file terlalu besar. Maksimal 5MB.")
          this.value = ""
          return
        }

        // Validasi tipe file
        const allowedTypes = ["image/jpeg", "image/jpg", "image/png", "application/pdf"]
        if (!allowedTypes.includes(file.type)) {
          alert("Tipe file tidak didukung. Gunakan JPG, PNG, atau PDF.")
          this.value = ""
          return
        }
      }
    })
  }

  // Auto-hide alert messages
  const alerts = document.querySelectorAll(".alert")
  alerts.forEach((alert) => {
    setTimeout(() => {
      alert.style.opacity = "0"
      setTimeout(() => {
        alert.style.display = "none"
      }, 300)
    }, 5000)
  })

  // Responsive navigation
  const navToggle = document.createElement("button")
  navToggle.innerHTML = "☰"
  navToggle.className = "nav-toggle"
  navToggle.style.display = "none"

  // Add mobile menu functionality if needed
  if (window.innerWidth <= 768) {
    const navMenu = document.querySelector(".nav-menu")
    if (navMenu) {
      navToggle.style.display = "block"
      navToggle.addEventListener("click", () => {
        navMenu.classList.toggle("active")
      })
    }
  }
})

// Fungsi untuk format angka dengan pemisah ribuan
function formatRupiah(angka) {
  return new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
    minimumFractionDigits: 0,
  }).format(angka)
}

// Fungsi untuk konfirmasi hapus (jika diperlukan)
function konfirmasiHapus(pesan) {
  return confirm(pesan || "Apakah Anda yakin ingin menghapus data ini?")
}

// Fungsi untuk loading state
function showLoading(element) {
  if (element) {
    element.innerHTML = "Memproses..."
    element.disabled = true
  }
}

function hideLoading(element, originalText) {
  if (element) {
    element.innerHTML = originalText || "Submit"
    element.disabled = false
  }
}
