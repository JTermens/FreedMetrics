S'ha d'afegir aquest codi al final de la funcio page_footer a lib_FreedMetrics.inc.php:

  <script type=\"text/javascript\">
    $(document).ready(function () {
        $('#table_History').DataTable();
    });
  </script>
