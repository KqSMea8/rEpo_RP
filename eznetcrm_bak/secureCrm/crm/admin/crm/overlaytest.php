<? require_once("../includes/header.php");?>

<style>
 /* use a semi-transparent image for the overlay */
  #overlay {
    background-image:url(images/transparent.png);
    color:#efefef;
    height:450px;
  }
  /* container for external content. uses vertical scrollbar, if needed */
  div.contentWrap {
    height:441px;
    overflow-y:auto;
  }
</style>

<script>

$(function() {
 
    // if the function argument is given to overlay,
    // it is assumed to be the onBeforeLoad event listener
    $("a[rel]").overlay({
 
        mask: 'darkred',
        effect: 'apple',
 
        onBeforeLoad: function() {
 
            // grab wrapper element inside content
            var wrap = this.getOverlay().find(".contentWrap");
 
            // load the page specified in the trigger
            wrap.load(this.getTrigger().attr("href"));
        }
 
    });
});
</script>
<!-- external page is given in the href attribute (as it should be) -->
<a href="viewDocument.php" rel="#overlay" style="text-decoration:none">
  <!-- remember that you can use any element inside the trigger -->
  <button type="button" style=" color:transparent;">Show external page in overlay</button>
</a>
 
<!-- another link. uses the same overlay -->
<a href="external-content2.htm" rel="#overlay" style="text-decoration:none">
  <button type="button">Show another page</button>
</a>

<div class="apple_overlay" id="overlay">
  <!-- the external content is loaded inside this tag -->
  <div class="contentWrap"></div>
</div>




