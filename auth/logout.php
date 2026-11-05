<?php
session_start();
session_destroy();
echo "<script>
    localStorage.removeItem('sipas_auth');
    window.location.href = 'index.php?pesan=logout';
</script>";
?>