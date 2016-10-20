<footer style="background:#222222; padding-top:10px;">
 <div style="float:right; width:100%; text-align:right; display:inline-block;">
        Developed & Design by <a href="http://www.mungood.com/en/" style="color:#e66396;">Mungood</a>
        </div>
</footer>

<!-- Modal -->
<div id="myModalLoading" class="modal hide " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h3 id="myModalLabel">Loading...</h3>
  </div>
  <div class="modal-body" style="text-align:center;">
    <p><img src="../img/loading2.gif" width="128" height="128" /></p>
  </div>
  
</div>


<script>
var webApp = function () {

	    var n = function () {
        var e = $("#primary-nav > ul > li > a");
        e.filter(function () {
            return $(this).next().is("ul")
        }).each(function (e, t) {
            $(t).append("<span>" + $(t).next("ul").children().length + "</span>")
        });
        e.click(function () {
            var e = $(this);
            if (e.next("ul").length > 0) {
                if (e.parent().hasClass("active") !== true) {
                    if (e.hasClass("open")) {
                        e.removeClass("open").next().slideUp(250)
                    } else {
                        $("#primary-nav li > a.open").removeClass("open").next().slideUp(250);
                        e.addClass("open").next().slideDown(250)
                    }
                }
                return false
            }
            return true
        })
    };
	
	  var u = function () {
		
        var e = 150;
        var t = 250;
        var n = $(".menu-link");
        var r = $(".submenu-link");
        n.each(function (e, t) {
            $(t).append("<span>" + $(t).next("ul").find("a").not(".submenu-link").length + "</span>")
        });
        r.each(function (e, t) {
            $(t).append("<span>" + $(t).next("ul").children().length + "</span>")
        });
        n.click(function () {
            var n = $(this);
			
            if (n.parent().hasClass("active") !== true) {
                if (n.hasClass("open")) {
                    n.removeClass("open").next().slideUp(e)
                } else {
                    $(".menu-link.open").removeClass("open").next().slideUp(e);
                    n.addClass("open").next().slideDown(t)
                }
            }
            return false
        });
        r.click(function () {
            var n = $(this);
			
            if (n.parent().hasClass("active") !== true) {
                if (n.hasClass("open")) {
                    n.removeClass("open").next().slideUp(e)
                } else {
                    n.closest("ul").find(".submenu-link.open").removeClass("open").next().slideUp(e);
                    n.addClass("open").next().slideDown(t)
                }
            }
            return false
        })
    };

	
    return {
        init: function () {
            //n();
			u();
			  $('[data-toggle="tooltip"], .enable-tooltip').tooltip({
            container: "body",
            animation: false
        });
        }
    }
}();

  

$(function () {
    webApp.init();
	
	$('.icheckbox').iCheck({
		checkboxClass: 'icheckbox_square-blue',
		radioClass: 'iradio_square',
		increaseArea: '20%' // optional
	  });
	
	
	$( "#input_search" ).keypress(function( event ) {
	  if ( event.which == 13 ) {
		 event.preventDefault();
		sysListTextSearch();
	  }
	 });
	
	
})
</script>
<?
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
mysql_close();
?>