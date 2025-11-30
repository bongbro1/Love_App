// 📂 public/js/utils/ui.js
export function showLoading(message = "Loading ...", sub = "Vui lòng chờ trong giây lát 💌") {
    const overlay = document.getElementById("loadingOverlay");
    if (!overlay) return;

    overlay.querySelector("p.text-lg").innerText = message;
    overlay.querySelector("p.text-sm").innerText = sub;
    overlay.classList.remove("hidden");
}

/**
 * Ẩn loading overlay
 */
export function hideLoading() {
    const overlay = document.getElementById("loadingOverlay");
    if (!overlay) return;

    overlay.classList.add("hidden");
}
