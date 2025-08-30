$(document).ready(function () {
    AOS.init();
    const currentYear = new Date().getFullYear();
    $('#year').text(currentYear);

    // Toggle mobile menu
    $('#toggle-menu').click(function () {
        $(this).toggleClass('open');
        $('#mobile-menu').toggleClass('-translate-x-full');
        $('#mobile-menu-overlay').toggleClass('hidden');
        $('body').toggleClass('overflow-hidden');
    });

    // Close mobile menu
    $('#close-mobile-menu, #mobile-menu-overlay').click(function () {
        $('#toggle-menu').removeClass('open');
        $('#mobile-menu').addClass('-translate-x-full');
        $('#mobile-menu-overlay').addClass('hidden');
        $('body').removeClass('overflow-hidden');
    });

    // Toggle desktop sidebar
    $('#toggle-sidebar').click(function () {
        $('#sidebar').toggleClass('collapsed');
        $('#main-content').toggleClass('expanded');
    });

    // Toggle notifications dropdown
    $('#notifications-dropdown-toggle').click(function (e) {
        e.stopPropagation();
        $('#notifications-dropdown').toggleClass('hidden');
        $('#user-dropdown').addClass('hidden');
    });

    // Toggle user dropdown
    $('#user-dropdown-toggle').click(function (e) {
        e.stopPropagation();
        $('#user-dropdown').toggleClass('hidden');
        $('#notifications-dropdown').addClass('hidden');
    });

    // Close dropdowns when clicking outside
    $(document).click(function () {
        $('#notifications-dropdown, #user-dropdown').addClass('hidden');
    });

    // Prevent dropdown from closing when clicking inside
    $('#notifications-dropdown, #user-dropdown').click(function (e) {
        e.stopPropagation();
    });

    // Resources Usage Chart
    const ctx = document.getElementById('resourcesChart').getContext('2d');
    const resourcesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Library', 'Wi-Fi', 'Hostel', 'Cafeteria', 'Sports'],
            datasets: [{
                label: 'Usage (%)',
                data: [85, 80, 64, 65, 50],
                backgroundColor: [
                    'rgba(16, 185, 129, 0.7)',
                    'rgba(59, 130, 246, 0.7)',
                    'rgba(251, 191, 36, 0.7)',
                    'rgba(168, 85, 247, 0.7)',
                    'rgba(239, 68, 68, 0.7)'
                ],
                borderRadius: 6,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        color: "#6B7280"
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                },
                x: {
                    ticks: {
                        color: "#6B7280"
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                }
            }
        }
    });

    // Handle dark mode for chart
    function updateChartColors() {
        const isDarkMode = document.documentElement.classList.contains('dark');
        resourcesChart.options.scales.y.grid.color = isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
        resourcesChart.options.scales.x.grid.color = isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
        resourcesChart.options.scales.y.ticks.color = isDarkMode ? 'rgba(255, 255, 255, 0.7)' : '#6B7280';
        resourcesChart.options.scales.x.ticks.color = isDarkMode ? 'rgba(255, 255, 255, 0.7)' : '#6B7280';
        resourcesChart.update();
    }

    // Initialize chart colors
    updateChartColors();

    // Update chart colors on dark mode change
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', updateChartColors);
});