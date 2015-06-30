jQuery(function() {
  // Ask if we really want to delete a video
  jQuery('#doaction2').click(function() {
    return confirm('Do you really want to delete this transaction? This cannot be undone.');
  });
});
