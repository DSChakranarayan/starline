
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('chart'), {
  type:'bar',
  data:{
    labels:['Jan','Feb','Mar','Apr','May'],
    datasets:[{ label:'Sales', data:[12,19,10,25,22] }]
  }
});
</script>

</body>
</html>