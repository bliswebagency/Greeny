<div id="greenystatus">
Loading...
</div>

<script>
$.ajax({
   type: "POST",
   url: "/index.php?ACT=<?php echo $actid; ?>",
   data: "name=John&location=Boston",
   success: function(msg){
     $('#greenystatus').html(msg);
     
     //If this is a new environment
     if (msg.indexOf('New Environment Recorded...') != -1) $.ee_notice("Greeny: Discovered new environment",{type:'success',open:true});
     
     //If we can see that this version of EE came from a different server
     if (msg.indexOf('new record') != -1) $.ee_notice("Greeny: Upload paths have been updated",{type:'success',open:true});
   }
 });
</script>