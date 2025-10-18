document.addEventListener('DOMContentLoaded', () => {

    // Mobile Menu Toggle for landing page and others
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileNav = document.getElementById('mobile-nav');
    if (mobileMenuBtn && mobileNav) {
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenuBtn.classList.toggle('active');
            mobileNav.classList.toggle('active');
        });
    }

    // Payment Success Countdown
    const countdownEl = document.getElementById('countdown');
    if (countdownEl) {
        let timeLeft = 3;
        const interval = setInterval(() => {
            timeLeft--;
            if (countdownEl) {
                countdownEl.textContent = timeLeft;
            }
            if (timeLeft <= 0) {
                clearInterval(interval);
                window.location.href = '/kos_fitness/member/card.php';
            }
        }, 1000);
    }

    // Delete confirmation for admin list
    const deleteLinks = document.querySelectorAll('.delete-link');
    deleteLinks.forEach(link => {
        link.addEventListener('click', (event) => {
            if (!confirm('คุณแน่ใจหรือไม่ว่าต้องการลบผู้ใช้นี้?')) {
                event.preventDefault();
            }
        });
    });

    // ApexCharts Initialization (if ApexCharts is loaded)
    const initApexCharts = () => {
        if (typeof ApexCharts === 'undefined') {
            return;
        }

        // Members by Package Chart (Pie)
        const membersChartEl = document.getElementById('chart-members');
        if (membersChartEl && membersChartEl.dataset.chartData) {
            const data = JSON.parse(membersChartEl.dataset.chartData);
            const options = {
                chart: { type: 'pie', background: 'transparent', height: 320 },
                labels: data.map(d => d.name),
                series: data.map(d => parseInt(d.members)),
                colors: ['#F97316', '#FB923C', '#FDBA74', '#FED7AA'],
                legend: { labels: { colors: '#ccc' } },
                theme: { mode: 'dark' }
            };
            new ApexCharts(membersChartEl, options).render();
        }

        // Revenue by Month Chart (Bar.)
        const revenueChartEl = document.getElementById('chart-revenue');
        if (revenueChartEl && revenueChartEl.dataset.chartData) {
            const data = JSON.parse(revenueChartEl.dataset.chartData);
            const options = {
                chart: { type: 'bar', background: 'transparent', height: 320 },
                series: [{ name: 'รายได้ (บาท)', data: data.map(d => parseFloat(d.revenue)) }],
                xaxis: {
                    categories: data.map(d => d.ym),
                    labels: { style: { colors: '#ccc' } }
                },
                yaxis: { labels: { style: { colors: '#ccc' } } },
                colors: ['#F97316'],
                grid: { borderColor: '#333' },
                theme: { mode: 'dark' }
            };
            new ApexCharts(revenueChartEl, options).render();
        }
    };

    initApexCharts();
});