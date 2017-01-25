$(document).ready(function(){
	
	$("#viewPrint").click(function(){
		$("#main").hide();
		$("#viewPrint").hide();
		$("#print").show();
		$.colorbox({
			top: 0,
			left: 0,
			inline: true,
			width: "900px",
			height: "650px",
			href: ".form",
			onClosed: function(){
				$("#main").show();
				$("#print").hide();
				$("#viewPrint").show();
			}
		});
	});


    function printDiv() {
        var printContents = document.getElementById("formPerfil").innerHTML;
        w=window.open();
        w.document.write(printContents);
        w.print();
        w.close();
    }

	$("#print").click(function(){
		$(this).hide();
       window.print();

		$(this).show();
	});
	
});