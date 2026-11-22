// ConvoManage Client Utilities
document.addEventListener("DOMContentLoaded", function () {
    // Auto-dismiss alerts
    const alerts = document.querySelectorAll(".error-message, .alert-success");
    alerts.forEach(function (alert) {
        setTimeout(function () {
            alert.style.transition = "opacity 0.5s ease";
            alert.style.opacity = "0";
            setTimeout(function () { alert.remove(); }, 500);
        }, 4000);
    });

    // Copy join code helper
    window.copyJoinCode = function (code) {
        navigator.clipboard.writeText(code).then(function () {
            showToast("Join code copied to clipboard: " + code);
        }).catch(function () {
            prompt("Copy this join code:", code);
        });
    };

    function showToast(message) {
        let toast = document.createElement("div");
        toast.innerText = message;
        toast.style.position = "fixed";
        toast.style.bottom = "20px";
        toast.style.right = "20px";
        toast.style.background = "#4f46e5";
        toast.style.color = "#ffffff";
        toast.style.padding = "12px 20px";
        toast.style.borderRadius = "8px";
        toast.style.boxShadow = "0 4px 12px rgba(0,0,0,0.15)";
        toast.style.zIndex = "9999";
        toast.style.fontSize = "14px";
        toast.style.fontFamily = "'Poppins', sans-serif";
        document.body.appendChild(toast);
        setTimeout(function () {
            toast.style.transition = "opacity 0.5s ease";
            toast.style.opacity = "0";
            setTimeout(function () { toast.remove(); }, 500);
        }, 3000);
    }
});
