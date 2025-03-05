document.addEventListener("DOMContentLoaded", function () {
    const toggleButton = document.getElementById("theme-toggle");
    
    if (!toggleButton) {
        console.error("ERROR: Botón 'theme-toggle' no encontrado.");
        return;
    }

    const savedTheme = localStorage.getItem("theme") || "light";
    document.documentElement.setAttribute("data-theme", savedTheme);
    updateButtonIcon(savedTheme);

    toggleButton.addEventListener("click", (e) => {
        e.preventDefault();
        const currentTheme = document.documentElement.getAttribute("data-theme");
        const newTheme = currentTheme === "dark" ? "light" : "dark";
        
        document.documentElement.setAttribute("data-theme", newTheme);
        localStorage.setItem("theme", newTheme);
        updateButtonIcon(newTheme);
    });

    function updateButtonIcon(theme) {
        const icon = theme === "dark" ? "fa-sun" : "fa-moon";
        const text = theme === "dark" ? "Modo claro" : "Modo oscuro";
        toggleButton.innerHTML = `<i class="fas ${icon}"></i> ${text}`;
    }
});