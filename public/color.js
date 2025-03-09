document.addEventListener("DOMContentLoaded", function () {
    const toggleButton = document.getElementById("theme-toggle");
    
    if (!toggleButton) {
        console.error("ERROR: Botón 'theme-toggle' no encontrado.");
        return;
    }

    // Cargar tema guardado o light por defecto
    const savedTheme = localStorage.getItem("theme") || "light";
    document.documentElement.setAttribute("data-theme", savedTheme);
    updateButtonIcon(savedTheme);

    toggleButton.addEventListener("click", (e) => {
        e.preventDefault();
        const currentTheme = document.documentElement.getAttribute("data-theme");
        const newTheme = currentTheme === "dark" ? "light" : "dark";
        
        // Actualizar atributo y almacenamiento
        document.documentElement.setAttribute("data-theme", newTheme);
        localStorage.setItem("theme", newTheme);
        
        updateButtonIcon(newTheme);
        
        // Forzar actualización de estilos en AdminLTE
        document.dispatchEvent(new CustomEvent("theme-changed"));
    });

    function updateButtonIcon(theme) {
        const icon = theme === "dark" ? "fa-sun" : "fa-moon";
        const text = theme === "dark" ? "Modo claro" : "Modo oscuro";
        
        // Limpia clases existentes y añade las nuevas
        toggleButton.querySelector('i').className = `fas ${icon}`;
        toggleButton.querySelector('a').innerHTML = `<i class="fas ${icon}"></i> ${text}`;
    }
});