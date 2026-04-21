
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js?v=<?php echo time(); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js?v=<?php echo time(); ?>"></script>
<script>
const services = <?php echo json_encode((int)$services); ?>;
const products = <?php echo json_encode((int)$products); ?>;
const total = <?php echo json_encode((int)$total); ?>;

const ctx = document.getElementById('myChart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Services', 'Products', 'Total'],
        datasets: [{
            label: 'Count',
            data: [services, products, total],
            backgroundColor: ['#3498db', '#2ecc71', '#f39c12']
        }]
    },
    options: {
        responsive: true
    }
});
</script>


</body>
</html>