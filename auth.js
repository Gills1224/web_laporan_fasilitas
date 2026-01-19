// REGISTER HANDLER
const registerForm = document.getElementById("registerForm");
if (registerForm) {
  registerForm.addEventListener("submit", function (e) {
    e.preventDefault();

    const nama = document.getElementById("nama").value.trim();
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();

    if (!nama || !email || !password) {
      alert("Semua kolom wajib diisi!");
      return;
    }

    let users = JSON.parse(localStorage.getItem("users")) || [];
    const userExist = users.find(u => u.email === email);
    if (userExist) {
      alert("Email sudah terdaftar!");
      return;
    }

    users.push({ nama, email, password });
    localStorage.setItem("users", JSON.stringify(users));

    alert("Registrasi berhasil! Silakan login.");
    window.location.href = "login.html";
  });
}

// LOGIN HANDLER
const loginForm = document.getElementById("loginForm");
if (loginForm) {
  loginForm.addEventListener("submit", function (e) {
    e.preventDefault();

    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();

    const users = JSON.parse(localStorage.getItem("users")) || [];
    const user = users.find(u => u.email === email && u.password === password);

    if (user) {
      localStorage.setItem("loggedInUser", JSON.stringify(user));
      alert("Login berhasil!");
      window.location.href = "laporan.html";
    } else {
      alert("Email atau password salah!");
    }
  });
}

// CEK LOGIN DI LAPORAN.HTML
if (window.location.pathname.endsWith("laporan.html")) {
  const user = JSON.parse(localStorage.getItem("loggedInUser"));
  if (!user) {
    alert("Silakan login terlebih dahulu!");
    window.location.href = "login.html";
  } else {
    console.log("User login:", user.nama);
  }
}

// LOGOUT FUNCTION
function logout() {
  localStorage.removeItem("loggedInUser");
  alert("Anda telah logout!");
  window.location.href = "login.html";
}