// Navigation JavaScript - Mobile Menu Toggle
document.addEventListener("DOMContentLoaded", () => {
  // Mobile menu toggle
  const navToggle = document.querySelector(".nav-toggle")
  const navMenu = document.querySelector(".nav-menu")

  // Create mobile toggle button if it doesn't exist
  if (!navToggle && window.innerWidth <= 768) {
    const toggle = document.createElement("button")
    toggle.className = "nav-toggle"
    toggle.innerHTML = "☰"
    toggle.setAttribute("aria-label", "Toggle navigation menu")

    const navContainer = document.querySelector(".nav-container")
    navContainer.appendChild(toggle)
  }

  // Toggle mobile menu
  function toggleMobileMenu() {
    const toggle = document.querySelector(".nav-toggle")
    const menu = document.querySelector(".nav-menu")

    if (toggle && menu) {
      toggle.addEventListener("click", () => {
        menu.classList.toggle("active")

        // Change icon
        if (menu.classList.contains("active")) {
          toggle.innerHTML = "✕"
        } else {
          toggle.innerHTML = "☰"
        }
      })
    }
  }

  // Close mobile menu when clicking on a link
  function closeMobileMenuOnClick() {
    const navLinks = document.querySelectorAll(".nav-link")
    const navMenu = document.querySelector(".nav-menu")
    const navToggle = document.querySelector(".nav-toggle")

    navLinks.forEach((link) => {
      link.addEventListener("click", () => {
        if (window.innerWidth <= 768) {
          navMenu.classList.remove("active")
          if (navToggle) {
            navToggle.innerHTML = "☰"
          }
        }
      })
    })
  }

  // Close mobile menu when clicking outside
  function closeMobileMenuOnOutsideClick() {
    document.addEventListener("click", (event) => {
      const navMenu = document.querySelector(".nav-menu")
      const navToggle = document.querySelector(".nav-toggle")
      const navContainer = document.querySelector(".nav-container")

      if (navMenu && navToggle && navContainer) {
        if (!navContainer.contains(event.target) && navMenu.classList.contains("active")) {
          navMenu.classList.remove("active")
          navToggle.innerHTML = "☰"
        }
      }
    })
  }

  // Handle window resize
  function handleWindowResize() {
    window.addEventListener("resize", () => {
      const navMenu = document.querySelector(".nav-menu")
      const navToggle = document.querySelector(".nav-toggle")

      if (window.innerWidth > 768) {
        if (navMenu) {
          navMenu.classList.remove("active")
        }
        if (navToggle) {
          navToggle.innerHTML = "☰"
        }
      }
    })
  }

  // Initialize all functions
  toggleMobileMenu()
  closeMobileMenuOnClick()
  closeMobileMenuOnOutsideClick()
  handleWindowResize()

  // Smooth scroll for anchor links
  const anchorLinks = document.querySelectorAll('a[href^="#"]')
  anchorLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      const targetId = this.getAttribute("href")
      const targetElement = document.querySelector(targetId)

      if (targetElement) {
        e.preventDefault()
        targetElement.scrollIntoView({
          behavior: "smooth",
          block: "start",
        })
      }
    })
  })
})
