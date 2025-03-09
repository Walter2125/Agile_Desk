document.addEventListener("DOMContentLoaded", function () {
    console.log("Script de tema cargado");
    
    const toggleButton = document.getElementById("theme-toggle");
    console.log("Botón encontrado:", toggleButton);

    if (!toggleButton) {
        console.error("ERROR: Botón 'theme-toggle' no encontrado.");
        return;
    }
    
    const savedTheme = localStorage.getItem("theme") || "light";
    document.documentElement.setAttribute("data-theme", savedTheme);
    updateButtonIcon(savedTheme);
    
    // Apply theme to FullCalendar styles
    applyThemeToFullCalendar(savedTheme);
    
    toggleButton.addEventListener("click", (e) => {
        console.log("Botón presionado");
        e.preventDefault();
        const currentTheme = document.documentElement.getAttribute("data-theme");
        console.log("Tema actual:", currentTheme);
        const newTheme = currentTheme === "dark" ? "light" : "dark";
        console.log("Nuevo tema:", newTheme);
        
        // Update FullCalendar styles when theme changes
        applyThemeToFullCalendar(newTheme);
        
        // Dispatch a custom event that other scripts can listen for
        document.dispatchEvent(new CustomEvent('themeChanged', { detail: { theme: newTheme } }));
    });
    
    function updateButtonIcon(theme) {
        const icon = theme === "dark" ? "fa-sun" : "fa-moon";
        const text = theme === "dark" ? "Modo claro" : "Modo oscuro";
        toggleButton.innerHTML = `<i class="fas ${icon}"></i> ${text}`;
    }
    
    function applyThemeToFullCalendar(theme) {
        // This function helps ensure the FullCalendar styles are properly applied
        // The actual styling is handled by the CSS
        
        // Force redraw if needed for complex components
        if (document.querySelector('.fc')) {
            document.querySelectorAll('.fc').forEach(cal => {
                cal.style.display = 'none';
                // Force reflow
                void cal.offsetHeight;
                cal.style.display = '';
            });
        }
    }
});